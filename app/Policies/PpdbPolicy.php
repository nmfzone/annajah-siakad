<?php

namespace App\Policies;

use App\Models\PpdbUser;
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

    public function view(User $user, PpdbUser $ppdbUser): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, PpdbUser $ppdbUser): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, PpdbUser $ppdbUser): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, ?PpdbUser $ppdbUser = null): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, PpdbUser $ppdbUser): bool
    {
        return $user->isAdmin();
    }
}
