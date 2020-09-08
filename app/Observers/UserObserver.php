<?php

namespace App\Observers;

use App\Enums\Role;
use App\Models\StudentProfile;
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

    /**
     * Listen to the User created event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        if ($user->role == Role::STUDENT) {
            $user->studentProfile()->save(new StudentProfile());
        }
    }
}
