<?php

namespace App\Policies;

use App\Models\AcademicYear;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AcademicYearPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability): ?bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, AcademicYear $academicYear): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, AcademicYear $academicYear): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, ?AcademicYear $academicYear = null): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, AcademicYear $academicYear): bool
    {
        return $user->isAdmin();
    }
}
