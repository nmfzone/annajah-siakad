<?php

use App\Enums\AcademicClassName;
use App\Enums\AttendanceType;
use App\Enums\Role;
use App\Models\AcademicClass;
use App\Models\AcademicClassCourse;
use App\Models\AcademicClassCourseStudent;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Site;
use App\Models\Student;
use App\Models\User;
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
        ]);

        /** @var \App\Models\AcademicYear $academicYear */
        $academicYear = $site->academicYears()->save(new AcademicYear([
            'name' => '2020/2021',
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
                'nis' => Student::generateNis($site),
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
    }
}
