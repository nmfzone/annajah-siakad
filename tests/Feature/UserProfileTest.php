<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesSite;
use Tests\Concerns\CreatesUser;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use CreatesSite,
        CreatesUser,
        RefreshDatabase;

    protected $site;

    protected function setUp(): void
    {
        parent::setUp();

        $this->site = $this->createSubSite();
    }

    /** @test */
    public function student_can_update_their_profile()
    {
        $user = $this->createStudentFor($this->site, [], [
            'name' => 'Jane Doe',
            'gender' => 0,
        ]);
        $this->actingAs($user);

        $birthDate = now()->format('d-m-Y');

        $this
            ->put($this->getFullSubUrl(
                $this->site,
                "backoffice/pengguna/{$user->id}"
            ), [
                'name' => 'John Doe',
                'gender' => 1,
                'birth_place' => 'Yogyakarta',
                'birth_date' => $birthDate,
            ])
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas($user->getTable(), [
            'name' => 'John Doe',
            'gender' => 1,
            'birth_place' => 'Yogyakarta',
        ]);

        $user = $user->fresh();
        $this->assertEquals(
            $birthDate,
            $user->birth_date->format('d-m-Y')
        );
    }

    /** @test */
    public function password_is_not_changed_if_left_blank()
    {
        $user = $this->createStudentFor($this->site, [], [
            'name' => 'Jane Doe',
            'password' => bcrypt('secret'),
        ]);
        $this->actingAs($user);

        $this
            ->put($this->getFullSubUrl(
                $this->site,
                "backoffice/pengguna/{$user->id}"
            ), [
                'name' => 'John Doe',
                'gender' => 1,
                'birth_place' => 'Yogyakarta',
                'birth_date' => now()->format('d-m-Y'),
            ])
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $user = $user->fresh();
        $this->assertTrue(password_verify('secret', $user->password));
    }
}
