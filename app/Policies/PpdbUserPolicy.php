<?php

namespace App\Policies;

use App\Models\PpdbUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PpdbUserPolicy extends BasePolicy
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
        return $user->is($ppdbUser->user) || $user->isAdmin();
    }

    public function viewPayment(User $user, PpdbUser $ppdbUser)
    {
        return $user->is($ppdbUser->user) || $user->isAdmin();
    }

    public function create(User $user)
    {
        return true;
    }

    public function createPayment(User $user, PpdbUser $ppdbUser)
    {
        return $user->is($ppdbUser->user) || $user->isAdmin();
    }

    public function acceptPayment(User $user, PpdbUser $ppdbUser)
    {
        return $user->isAdmin();
    }

    public function declineOrCancelPayment(User $user, PpdbUser $ppdbUser)
    {
        return $user->isAdmin();
    }

    public function acceptAsStudent(User $user, PpdbUser $ppdbUser)
    {
        if (! $ppdbUser->transactionItem->isPaid() || ! $ppdbUser->ppdb->isActive()) {
            return false;
        }

        return $user->isAdmin();
    }

    public function declineOrCancelAsStudent(User $user, PpdbUser $ppdbUser)
    {
        if (! $ppdbUser->transactionItem->isPaid() || ! $ppdbUser->ppdb->isActive()) {
            return false;
        }

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
