<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\UsersDataTable;
use App\Enums\Role;
use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserUpdateUserableRequest;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    use HasSiteContext;

    public function index(Request $request, $userType)
    {
        $this->authorize('viewAny', [User::class, $userType]);

        $datatable = new UsersDataTable($request->user(), $userType);

        $userTypeFormatted = Str::title(Str::replaceFirst('+', ' & ', $userType));

        return $datatable->render(
            'backoffice.users.index',
            compact('userType', 'userTypeFormatted')
        );
    }

    public function create()
    {
        $this->authorize('create', User::class);

        return view('backoffice.users.create');
    }

    public function store(UserCreateRequest $request)
    {
        $site = site();

        DB::transaction(function () use ($request, $site) {
            $user = (new User)->newInstance($request->validated());
            $user->role = $request->role;
            $site->users()->save($user);

            if ($request->role === Role::STUDENT) {
                $user->studentProfiles()->save(new Student([
                    'nis' => Student::generateNis($site),
                ]), ['site_id' => $site->id]);
            } elseif (in_array($request->role, [Role::TEACHER, Role::HEAD_MASTER], true)) {
                $user->teacherProfiles()->save(new Teacher, ['site_id' => $site->id]);
            }
        });

        flash('Berhasil menambahkan pengguna.')->success();

        return redirect()->route('backoffice.users.index', $request->role);
    }

    public function show(User $user)
    {
        $this->userShouldBelongsToCurrentSite($user, 404, true);
        $this->authorize('view', $user);

        return view('backoffice.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->userShouldBelongsToCurrentSite($user, 404, true);
        $this->authorize('update', $user);

        return view('backoffice.users.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $this->userShouldBelongsToCurrentSite($user, 404, true);
        /** @var \App\Models\User $authUser */
        $authUser = $request->user();

        $user->update($request->validated());

        if ($authUser->is($user)) {
            flash('Berhasil memperbarui identitas Anda.')->success();
        } else {
            flash('Berhasil memperbarui identitas pengguna.')->success();
        }

        if ($request->input('to_previous')) {
            return redirect()->back();
        }

        if ($user->isSuperAdmin()) {
            return redirect()->back();
        }

        return redirect()->route('backoffice.users.index', $user->role);
    }

    public function updateUserable(UserUpdateUserableRequest $request, User $user)
    {
        $this->userShouldBelongsToCurrentSite($user);

        if ($user->studentProfiles->isEmpty() &&
            $user->teacherProfiles->isEmpty()) {
            abort(404);
        }

        $model = null;
        /** @var \App\Models\User $authUser */
        $authUser = $request->user();
        $site = site();

        if ($user->teacherProfiles->isNotEmpty()) {
            $model = $user->teacherProfileFor($site);
        } elseif ($user->studentProfiles->isNotEmpty()) {
            $model = $user->studentProfileFor($site);
        }

        $model->update($request->validated());

        if ($user->isStudent()) {
            if ($authUser->isSuperAdminOrAdmin()) {
                flash('Berhasil memperbarui data akademik pengguna.')->success();
            } else {
                flash('Berhasil memperbarui data akademik.')->success();
            }
        } else {
            flash('Berhasil memperbarui data.')->success();
        }

        if ($request->input('to_previous')) {
            return redirect()
                ->back()
                ->with('bottom-message', true);
        }

        return redirect()->route('backoffice.users.index', $user->role);
    }

    public function destroy(User $user)
    {
        $this->userShouldBelongsToCurrentSite($user);
        $this->authorize('delete', $user);

        if ($user->isSuperAdmin() || $user->isAdmin()) {
            flash('Tidak bisa menghapus pengguna ini.')->error();
        } else {
            try {
                $user->delete();
                flash('Berhasil menghapus pengguna.')->success();
            } catch (Exception $e) {
                report($e);
                flash('Gagal menghapus pengguna.')->error();
            }
        }

        return redirect()->route('backoffice.users.index', $user->role);
    }
}
