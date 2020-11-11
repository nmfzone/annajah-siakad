<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Enums\SelectionMethod;
use App\Http\Controllers\Concerns\HasSiteContext;
use App\Models\Student;
use App\Models\User;
use App\Services\PpdbService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PpdbController extends Controller
{
    use HasSiteContext;

    /**
     * @var \App\Services\PpdbService
     */
    protected $ppdbService;

    public function __construct(PpdbService $ppdbService)
    {
        $this->ppdbService = $ppdbService;
    }

    public function index(Request $request, $subDomain)
    {
        if (! $request->session()->has('registered')) {
            $this->middleware('guest');
        }

        $site = $this->site();

        $slides = $site->getMedia('ppdb_slides');

        $slides = [
            [
                'id' => 3,
                'image' => asset('images/slider-1_500.png')
            ],
            [
                'id' => 1,
                'image' => asset('images/slider-2.jpg')
            ],
        ];

        $ppdb = $this->ppdbService->currentPpdb();

        $viewName = sprintf('subs.%s.ppdb', $site->id);

        if (! view()->exists($viewName) || is_null($ppdb)) {
            abort(404);
        }

        return view($viewName, compact('slides', 'ppdb'));
    }

    public function store(Request $request, $subDomain)
    {
        $site = $this->site();
        $ppdb = $this->ppdbService->currentPpdb();

        $userRules = [
            'name' => 'required|string|min:3|max:40',
            'nickname' => 'required|string|min:3|max:15',
            'gender' => 'required|boolean',
            'birth_place' => 'required|string|min:3|max:40',
            'birth_date' => 'required|date_format:d-m-Y',
        ];
        $studentRules = [
            'no_kk' => 'required|digits_between:10,20',
            'previous_school' => 'required|string|min:10|max:50',
            'wali_name' => 'required|string|min:3|max:40',
            'wali_phone' => 'required|digits_between:9,20',
        ];

        $this->validate($request, $userRules + $studentRules + [
            'selection_method' => ['required', Rule::in(SelectionMethod::asArray())],
            'approval' => 'required',
        ]);

        $password = Str::randomPlus('numeric');

        DB::transaction(function () use ($request, $site, $userRules, $studentRules, $ppdb, $password) {
            $override = [
                'username' => User::generateUsername(Role::STUDENT, $ppdb->academicYear->from),
                'password' => bcrypt($password),
                'role' => Role::STUDENT,
                'birth_date' => Carbon::createFromFormat('d-m-Y', $request->birth_date)
            ];
            $user = User::forceCreate(
                $request->merge($override)
                    ->only(array_keys($userRules + $override))
            );
            $site->users()->save($user);

            $override = [
                'nis' => Student::generateNis($site),
            ];
            $user->studentProfiles()->save(new Student(
                $request->merge($override)
                    ->only(array_keys($studentRules + $override))
            ), ['site_id' => $site->id]);

            $this->ppdbService->addNewRegistrar($ppdb, $user, [
                'selection_method' => $request->selection_method,
            ]);

            auth()->loginUsingId($user->id);
        });

        return redirect()->back()
            ->with('registered', true)
            ->with('password', $password);
    }
}
