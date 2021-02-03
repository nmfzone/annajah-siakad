<?php

namespace Database\Seeders;

use App\Enums\PaymentType;
use App\Enums\Role;
use App\Imports\StudentsImport;
use App\Models\AcademicYear;
use App\Models\Ppdb;
use App\Models\Site;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class PreliminaryDataSeeder extends Seeder
{
    public function run()
    {
        /** @var \App\Models\Site $site */
        $site = Site::create([
            'title' => 'SMPIT Muhammadiyah An Najah',
            'site_title' => 'SMPIT Muhammadiyah An Najah Jatinom Klaten',
            'domain' => 'smpit.' . config('app.host'),
            'address' => 'Jalan Lingkar Utara Jatinom, Dukuh Bonyokan, Jatinom, Klaten',
            'email' => 'info@smpit.muhannajah.sch.id',
            'phone' => '(0272) 3393415',
            'instagram' => 'smpitmuhannajah',
            'facebook' => 'Smpit-Muhammadiyah-An-Najah-320858588375921',
            'twitter' => 'smpitmuhannajah',
        ]);

        $site->addMedia(resource_path('images/logo-smp.png'))
            ->preservingOriginal()
            ->toMediaCollection('logo');

        Site::create([
            'title' => 'SDIT Muhammadiyah An Najah',
            'site_title' => 'SDIT Muhammadiyah An Najah Jatinom Klaten',
            'domain' => 'sdit.' . config('app.host'),
            'address' => 'Jalan Lingkar Utara Jatinom, Dk. Dukuh, Dukuh Bonyokan, Jatinom, Klaten',
            'email' => 'info@sdit.muhannajah.sch.id',
            'phone' => '(0272) 3393415',
        ]);

        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'mail@muhannajah.sch.id',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
            'role' => Role::SUPERADMIN,
        ]);
        $superAdmin->username = 'annajah';
        $superAdmin->save();

        $editor = User::create([
            'name' => 'Editor SMP',
            'email' => 'editor@smpit.muhannajah.sch.id',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
            'role' => Role::EDITOR,
        ]);
        $editor->username = 'smpit-editor';
        $site->users()->save($editor);

        $admin = User::create([
            'name' => 'Administrator SMP',
            'email' => 'mail@smpit.muhannajah.sch.id',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
            'role' => Role::ADMIN,
        ]);
        $admin->username = 'smpit-admin';
        $site->users()->save($admin);

        $teacher = $site->users()->save(new User([
            'name' => 'Kartika Nur Kholidah, S.Kom',
            'email' => 'kartikanurkholidah@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
            'role' => Role::TEACHER,
        ]));

        $teacher->teacherProfiles()->save(new Teacher, ['site_id' => $site->id]);

        (new StudentsImport($site))->queue(resource_path('files/DataSantriAll.xlsx'));

        /** @var \App\Models\AcademicYear $academicYear */
        $academicYear = $site->academicYears()->save(new AcademicYear([
            'from' => 2021,
            'to' => 2022,
        ]));

        /** @var \App\Models\Ppdb $ppdb */
        $ppdb = $academicYear->ppdb()->save(new Ppdb([
            'started_at' => now(),
            'ended_at' => now()->addMonths(2),
        ]));

        $ppdb->settings()->set('payment', [
            'payment_type' => PaymentType::BANK_TRANSFER,
            'provider' => 'bni',
            'provider_number' => '0912570453',
            'provider_holder_name' => 'Kartika Nur Kholidah',
        ]);

        $ppdb->settings()->set('price', 100000);

        $ppdb->settings()->set('contact_persons', [
            [
                'name' => 'Ustadzah Ratri',
                'number' => '082135002033',
            ],
            [
                'name' => 'Ustadzah Rahma',
                'number' => '081225777431',
            ]
        ]);
    }
}
