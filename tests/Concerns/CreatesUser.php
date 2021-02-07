<?php

namespace Tests\Concerns;

use App\Enums\Role;
use App\Models\Site;
use App\Models\Student;
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

    public function createStudentFor(Site $site, $attributes = [], $userAttributes = []): User
    {
        $user = User::factory()->create(array_merge([
            'password' => bcrypt('12345678'),
            'role' => Role::STUDENT,
        ], $userAttributes));

        $site->users()->save($user);

        $user->studentProfiles()->save(
            Student::factory()->make(array_merge([
                'nis' => Student::generateNis($this->site),
                'accepted_at' => now(),
                'graduated_at' => null,
            ], $attributes)),
            ['site_id' => $site->id]
        );

        return $user;
    }
}
