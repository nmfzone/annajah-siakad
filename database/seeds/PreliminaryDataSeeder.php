<?php

use App\Enums\PaymentType;
use App\Enums\PpdbSetting;
use App\Enums\Role;
use App\Imports\StudentsImport;
use App\Models\AcademicYear;
use App\Models\Ppdb;
use App\Models\Site;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

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
            'address' => 'Jalan Lingkar Utara Jatinom, Dukuh Bonyokan, Jatinom, Klaten',
            'email' => 'info@smpit.muhannajah.sch.id',
            'phone' => '(0272) 3393415',
            'instagram' => 'smpitmuhannajah',
            'facebook' => 'Smpit-Muhammadiyah-An-Najah-320858588375921',
            'twitter' => 'smpitmuhannajah',
        ]);

        $destinationPath = tmp_path('logo-smp.png');
        File::copy(resource_path('images/logo-smp.png'), $destinationPath);
        $site->addMedia($destinationPath)
            ->toMediaCollection('logo');

        factory(Site::class)->create([
            'title' => 'SDIT Muhammadiyah An Najah',
            'domain' => 'sdit.' . config('app.host'),
            'address' => 'Jalan Lingkar Utara Jatinom, Dk. Dukuh, Dukuh Bonyokan, Jatinom, Klaten',
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

        $ppdb->settings()->set(PpdbSetting::PAYMENTS, [
            [
                'payment_type' => PaymentType::BANK_TRANSFER,
                'provider' => 'bni',
                'provider_number' => '0912570453',
                'provider_holder_name' => 'Kartika Nur Kholidah',
            ]
        ]);

        $ppdb->settings()->set(PpdbSetting::PAYMENT_AMOUNT, 100000);

        $ppdb->settings()->set(PpdbSetting::CONTACT_PERSONS, [
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
