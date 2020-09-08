<?php

use App\Enums\AcademicClassName;
use App\Enums\AttendanceType;
use App\Enums\Role;
use App\Models\AcademicClass;
use App\Models\AcademicClassStudent;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\Course;
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
        /** @var \App\Models\AcademicYear $academicYear */
        $academicYear = AcademicYear::create([
            'name' => '2020/2021',
            'semester' => 1,
        ]);

        /** @var \App\Models\Course $course */
        $course = factory(Course::class)->create([
            'name' => 'Matematika'
        ]);
        $course2 = factory(Course::class)->create([
            'name' => 'Bahasa Indonesia'
        ]);

        /** @var \App\Models\AcademicClass $academicClass */
        $academicClass = $academicYear->academicClasses()->save(new AcademicClass([
            'class_name' => AcademicClassName::VII_MAKMUM,
            'course_id' => $course->id,
        ]));
        $academicYear->academicClasses()->save(new AcademicClass([
            'class_name' => AcademicClassName::VII_MAKMUM,
            'course_id' => $course2->id,
        ]));

        /** @var \App\Models\User $user */
        $student = factory(User::class)->create([
            'name' => 'Bimo Prakoso',
            'email' => 'bimo@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
            'role' => Role::STUDENT,
        ]);
        /** @var \App\Models\AcademicClassStudent $academicClassStudent */
        $academicClassStudent = $student->academicClassStudents()
            ->where('academic_class_id', $academicClass->id)
            ->first();

        $academicClass->students()->save(new AcademicClassStudent([
            'number' => 1,
            'student_id' => $student->id,
        ]));

        /** @var \App\Models\Attendance $attendace */
        $attendace = $academicClass->attendances()->save(new Attendance([
            'type' => AttendanceType::UTS,
            'name' => 'PTS',
            'started_at' => Carbon::parse('2020-09-07 08:00'),
            'ended_at' => Carbon::parse('2020-09-07 08:15'),
        ]));

        $attendace->academicClassStudents()->attach($academicClassStudent);
    }
}
