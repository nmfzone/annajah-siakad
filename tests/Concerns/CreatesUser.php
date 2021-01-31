<?php

namespace Tests\Concerns;

use App\Enums\Role;
use App\Models\Site;
use App\Models\User;

trait CreatesUser
{
    public function createAdminFor(Site $site): User
    {
        $user = User::factory()->make([
            'password' => bcrypt('12345678'),
            'role' => Role::ADMIN,
        ]);
        $user->username = 'admin-' . $user->username;
        $user->save();

        $site->users()->save($user);

        return $user;
    }
}
