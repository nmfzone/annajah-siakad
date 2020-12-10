<?php

namespace App\Policies;

use App\Models\PpdbUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PpdbPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    public function view(User $user, PpdbUser $ppdbUser)
    {
        return $user->isAdmin();
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, PpdbUser $ppdbUser)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, PpdbUser $ppdbUser)
    {
        return $user->isAdmin();
    }

    public function restore(User $user, ?PpdbUser $ppdbUser = null)
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, PpdbUser $ppdbUser)
    {
        return $user->isAdmin();
    }
}
