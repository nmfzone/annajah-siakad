<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Listen to the User creating event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function creating(User $user)
    {
        if ($user->username == null) {
            $user->username = User::generateUsername($user->role);
        }
    }
}
