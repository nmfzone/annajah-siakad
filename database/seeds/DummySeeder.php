<?php

use App\Enums\AttendanceType;
use App\Enums\PaymentType;
use App\Enums\PpdbSetting;
use App\Enums\Role;
use App\Enums\SelectionMethod;
use App\Models\AcademicClass;
use App\Models\AcademicClassCourse;
use App\Models\AcademicClassCourseStudent;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Ppdb;
use App\Models\Site;
use App\Models\Student;
use App\Models\User;
use App\Services\PpdbService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var \App\Models\Site $site */
        $site = Site::firstOrCreate([
            'domain' => 'smpit.' . config('app.host'),
        ], [
            'title' => 'SMPIT Muhammadiyah An Najah',
            'address' => 'Jalan Lingkar Utara Jatinom, Dukuh Bonyokan, Jatinom, Klaten',
            'email' => 'info@smpit.muhannajah.sch.id',
            'phone' => '(0272) 3393415',
            'instagram' => 'smpitmuhannajah',
            'facebook' => 'Smpit-Muhammadiyah-An-Najah-320858588375921',
            'twitter' => 'smpitmuhannajah',
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

        /** @var \App\Models\AcademicYear $academicYear */
        $academicYear = $site->academicYears()->save(new AcademicYear([
            'from' => 2020,
            'to' => 2021
        ]));

        /** @var \App\Models\Course $course */
        $course = $site->courses()->save(factory(Course::class)->make([
            'name' => 'Matematika'
        ]));
        $course2 = $site->courses()->save(factory(Course::class)->make([
            'name' => 'Bahasa Indonesia'
        ]));

        /** @var \App\Models\AcademicClass $academicClass */
        $academicClass = $academicYear->academicClasses()->save(new AcademicClass([
            'name' => 'VII Makmun',
        ]));

        /** @var \App\Models\AcademicClassCourse $academicClassCourse */
        $academicClassCourse = $academicClass->academicClassCourses()->save(new AcademicClassCourse([
            'course_id' => $course->id,
        ]));
        $academicClass->academicClassCourses()->save(new AcademicClassCourse([
            'course_id' => $course2->id,
        ]));

        /** @var \App\Models\User $user */
        $user = $site->users()->save(factory(User::class)->make([
            'name' => 'Bimo Prakoso',
            'email' => 'bimo@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
            'role' => Role::STUDENT,
        ]));

        $user->studentProfiles()->save(
            new Student([
                'nis' => Student::generateNis($site, 2017),
                'accepted_at' => Carbon::create(2017, 7, 1),
            ]),
            ['site_id' => $site->id]
        );

        /** @var \App\Models\AcademicClassCourseStudent $academicClassCourseStudent */
        $academicClassCourseStudent = $user->academicClassCourseStudents()
            ->where('academic_class_course_id', $academicClassCourse->id)
            ->first();

        $academicClassCourse->students()->save(new AcademicClassCourseStudent([
            'number' => 1,
            'student_id' => $user->id,
        ]));

        /** @var \App\Models\Attendance $attendace */
        $attendace = $academicClassCourse->attendances()->save(new Attendance([
            'type' => AttendanceType::UTS,
            'name' => 'PTS',
            'started_at' => Carbon::parse('2020-09-07 08:00'),
            'ended_at' => Carbon::parse('2020-09-07 08:15'),
        ]));

        $attendace->academicClassCourseStudents()->attach($academicClassCourseStudent);

        /** @var \App\Models\Ppdb $ppdb */
        $ppdb = $academicYear->ppdb()->save(new Ppdb([
            'started_at' => now(),
            'ended_at' => now()->addMonths(2),
        ]));

        $ppdb->settings()->set(PpdbSetting::PAYMENT, [
            'payment_type' => PaymentType::BANK_TRANSFER,
            'provider' => 'bni',
            'provider_number' => '28371903874',
            'provider_holder_name' => 'John Doe',
        ]);

        $ppdb->settings()->set(PpdbSetting::PRICE, 200000);

        $ppdb->settings()->set(PpdbSetting::CONTACT_PERSONS, [
            [
                'name' => 'John Doe',
                'number' => '081726367482',
            ],
        ]);

        $ppdbService = app()->make(PpdbService::class);

        $ppdbService->addNewRegistrar($ppdb, $user, [
            'selection_method' => SelectionMethod::PRESTASI,
        ]);
    }
}
