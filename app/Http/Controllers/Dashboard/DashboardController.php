<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $teacherCounts = User::whereRole(Role::TEACHER)->count();
        $allStudentCounts = User::whereRole(Role::STUDENT)->count();
        $graducatedStudentCounts = User::whereRole(Role::STUDENT)
            ->whereHas('studentProfile', function (Builder $query) {
                $query->whereNotNull('graduate_date');
            })->count();

        $studentCounts = $allStudentCounts - $graducatedStudentCounts;

        return view('dashboard', compact(
            'teacherCounts',
            'studentCounts',
            'graducatedStudentCounts'
        ));
    }
}
