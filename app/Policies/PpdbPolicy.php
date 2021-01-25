<?php

namespace App\Policies;

use App\Models\Ppdb;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PpdbPolicy extends BasePolicy
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

    public function view(User $user, Ppdb $ppdb): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Ppdb $ppdb): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Ppdb $ppdb): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, ?Ppdb $ppdb = null): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Ppdb $ppdb): bool
    {
        return $user->isAdmin();
    }
}
