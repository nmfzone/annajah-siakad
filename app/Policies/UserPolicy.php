<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    public function viewAny(User $user, $userType = null)
    {
        if (in_array($userType, [Role::ADMIN, Role::EDITOR, 'administrator+editor'])) {
            return false;
        }

        return $user->isNotStudent();
    }

    public function view(User $user, User $model)
    {
        return $user->is($model) || $user->isNotStudent();
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, User $model)
    {
        return $user->is($model) || $user->isAdmin();
    }

    public function updateUserable(User $user, User $model)
    {
        return $user->is($model) || $user->isAdmin();
    }

    public function delete(User $user, User $model)
    {
        return $user->isAdmin();
    }

    public function restore(User $user, User $model)
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, User $model)
    {
        return $user->isAdmin();
    }
}
