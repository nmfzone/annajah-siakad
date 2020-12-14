<?php

namespace App\Policies;

use App\Models\PpdbUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PpdbUserPolicy extends BasePolicy
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
        return $user->is($ppdbUser->user) || $user->isAdmin();
    }

    public function viewPayment(User $user, PpdbUser $ppdbUser): bool
    {
        return $user->is($ppdbUser->user) || $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function createPayment(User $user, PpdbUser $ppdbUser): bool
    {
        return $user->is($ppdbUser->user) || $user->isAdmin();
    }

    public function acceptPayment(User $user, PpdbUser $ppdbUser): bool
    {
        return $user->isAdmin();
    }

    public function declineOrCancelPayment(User $user, PpdbUser $ppdbUser): bool
    {
        return $user->isAdmin();
    }

    public function acceptAsStudent(User $user, PpdbUser $ppdbUser): bool
    {
        if (! $ppdbUser->transactionItem->isPaid() || ! $ppdbUser->ppdb->isActive()) {
            return false;
        }

        return $user->isAdmin();
    }

    public function declineOrCancelAsStudent(User $user, PpdbUser $ppdbUser): bool
    {
        if (! $ppdbUser->transactionItem->isPaid() || ! $ppdbUser->ppdb->isActive()) {
            return false;
        }

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
