<?php

use App\Enums\Role;
use App\Imports\StudentsImport;
use App\Models\Site;
use App\Models\Student;
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
        /** @var \App\Models\Site $site */
        $site = factory(Site::class)->create([
            'title' => 'SMPIT Muhammadiyah An Najah',
            'domain' => 'smpit.' . config('app.host'),
            'address' => 'Jalan Lingkar Utara Jatinom, Dukuh, Bonyokan, Jatinom, Klaten',
            'email' => 'info@smpit.muhannajah.sch.id',
            'phone' => '(0272) 3393415',
        ]);

        factory(Site::class)->create([
            'title' => 'SDIT Muhammadiyah An Najah',
            'domain' => 'sdit.' . config('app.host'),
            'address' => 'Jalan Lingkar Utara Jatinom, Dukuh, Bonyokan, Jatinom, Klaten',
            'email' => 'info@sdit.muhannajah.sch.id',
            'phone' => '(0272) 3393415',
        ]);

        $superAdmin = factory(User::class)->make([
            'name' => 'Super Administrator',
            'email' => 'mail@muhannajah.sch.id',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
            'role' => Role::SUPERADMIN,
        ]);
        $superAdmin->username = 'annajah';
        $superAdmin->save();

        $editor = factory(User::class)->make([
            'name' => 'Editor SMP',
            'email' => 'editor@smpit.muhannajah.sch.id',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
            'role' => Role::EDITOR,
        ]);
        $editor->username = 'smpit-editor';
        $site->users()->save($editor);

        $admin = factory(User::class)->make([
            'name' => 'Administrator SMP',
            'email' => 'mail@smpit.muhannajah.sch.id',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
            'role' => Role::ADMIN,
        ]);
        $admin->username = 'smpit-admin';
        $site->users()->save($admin);

        $site->users()->save(factory(User::class)->make([
            'name' => 'Kartika Nur Kholidah, S.Kom',
            'email' => 'kartikanurkholidah@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
            'role' => Role::TEACHER,
        ]));

        /** @var \App\Models\User $user */
        $user = $site->users()->save(factory(User::class)->make([
            'name' => 'Ahnaf',
            'email' => 'ahnaf@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
            'role' => Role::STUDENT,
        ]));

        $user->studentProfiles()->save(new Student([
            'graduated_at' => now()->subMonths(5),
        ]), ['site_id' => $site->id]);

        (new StudentsImport($site))->queue(resource_path('files/DataSantriAll.xlsx'));
    }
}
