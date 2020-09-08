<?php

use App\Enums\Role;
use App\Imports\StudentsImport;
use App\Models\User;
use Illuminate\Database\Seeder;

class PreliminaryDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = factory(User::class)->make([
            'name' => 'Administrator',
            'email' => 'annajahsmpit@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
            'role' => Role::ADMIN,
        ]);
        $admin->username = 'annajah-admin';
        $admin->save();

        factory(User::class)->create([
            'name' => 'Kartika Nur Kholidah, S.Kom',
            'email' => 'kartikanurkholidah@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
            'role' => Role::TEACHER,
        ]);

        $student = factory(User::class)->create([
            'name' => 'Ahnaf',
            'email' => 'ahnaf@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
            'role' => Role::STUDENT,
        ]);

        $student->studentProfile->update([
            'graduate_date' => '2020-05-10',
        ]);

        (new StudentsImport)->queue(resource_path('files/DataSantriAll.xlsx'));
    }
}
