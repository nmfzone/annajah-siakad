<?php

namespace Tests\Feature;

use App\Enums\SelectionMethod;
use App\Models\PpdbUser;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Concerns\CreatesPpdb;
use Tests\Concerns\CreatesSite;
use Tests\TestCase;

class PpdbRegistrationTest extends TestCase
{
    use WithFaker,
        CreatesPpdb,
        CreatesSite,
        RefreshDatabase;

    protected $site;

    protected $ppdb;

    protected function setUp(): void
    {
        parent::setUp();

        $this->site = $this->createSubSite();
        $this->ppdb = $this->createPpdbFor($this->site);
    }

    /** @test */
    public function a_visitor_can_register_to_the_ppdb()
    {
        $this->handleValidationExceptions();

        $userDetail = [
            'name' => 'John Doe',
            'nickname' => 'John',
            'gender' => 1,
            'birth_place' => $this->faker->city,
        ];

        $studentDetail = [
            'no_kk' => '3401011002930003',
            'previous_school' => 'SD Negeri 1 Yogyakarta',
            'wali_name' => 'Muhammad Toha',
            'wali_phone' => '081328913824',
        ];

        $birthDate = $this->faker->date('d-m-Y');

        $this
            ->post($this->getFullSubUrl(
                $this->site,
                'ppdb'
            ), array_merge($userDetail, $studentDetail, [
                'birth_date' => $birthDate,
                'selection_method' => SelectionMethod::TAHFIDZ,
                'approval' => true,
            ]))
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $user = User::where($userDetail)->firstOrFail();
        $this->assertEquals(
            $birthDate,
            $user->birth_date->format('d-m-Y')
        );

        $this->assertDatabaseHas((new Student())->getTable(), $studentDetail);

        $this->assertDatabaseHas((new PpdbUser())->getTable(), [
            'user_id' => $user->id,
            'ppdb_id' => $this->ppdb->id,
            'selection_method' => SelectionMethod::TAHFIDZ,
        ]);
    }
}
