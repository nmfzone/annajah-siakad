<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Role;
use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use HasSiteContext;

    public function index(Request $request)
    {
        $teacherCounts = User::whereRole(Role::TEACHER)
            ->forSite($this->site())
            ->count();
        $allStudentCounts = User::whereRole(Role::STUDENT)
            ->forSite($this->site())
            ->count();
        $graduatedStudentCounts = User::whereRole(Role::STUDENT)
            ->forSite($this->site())
            ->whereHas('studentProfiles', function (Builder $query) {
                $query->whereNotNull('graduated_at');
            })->count();

        $studentCounts = $allStudentCounts - $graduatedStudentCounts;

        return view('dashboard.index', compact(
            'teacherCounts',
            'studentCounts',
            'graduatedStudentCounts'
        ));
    }
}
