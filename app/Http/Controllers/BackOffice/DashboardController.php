<?php

namespace App\Http\Controllers\BackOffice;

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
        $site = site();
        $teacherCounts = User::whereRole(Role::TEACHER)
            ->forSite($site)
            ->count();
        $allStudentCounts = User::whereRole(Role::STUDENT)
            ->forSite($site)
            ->whereHas('studentProfiles', function (Builder $query) {
                $query->whereNotNull('accepted_at');
            })->count();
        $graduatedStudentCounts = User::whereRole(Role::STUDENT)
            ->forSite($site)
            ->whereHas('studentProfiles', function (Builder $query) {
                $query->whereNotNull('graduated_at');
            })->count();

        $studentCounts = $allStudentCounts - $graduatedStudentCounts;

        return view('backoffice.dashboard', compact(
            'teacherCounts',
            'studentCounts',
            'graduatedStudentCounts'
        ));
    }
}
