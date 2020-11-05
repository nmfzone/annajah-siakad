<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function creating(User $user)
    {
        if ($user->username == null) {
            $user->username = User::generateUsername($user->role);
        }
    }
}
