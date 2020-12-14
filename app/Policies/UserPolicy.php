<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability): ?bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user, $userType = null): bool
    {
        if (in_array($userType, [Role::ADMIN, Role::EDITOR, 'administrator+editor'])) {
            return false;
        }

        return $user->isNotStudent();
    }

    public function view(User $user, User $model): bool
    {
        return $user->is($model) || $user->isNotStudent();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, User $model): bool
    {
        return $user->is($model) || $user->isAdmin();
    }

    public function updateUserable(User $user, User $model): bool
    {
        return $user->is($model) || $user->isAdmin();
    }

    public function delete(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $user->isAdmin();
    }
}
