<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendancesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware([sprintf('role:%s', Role::STUDENT)]);
    }

    public function index(Request $request)
    {
        $attendances = Attendance::with('academicClassCourse.academicYear')
            ->where('is_open', true)
            ->get();

        $attendances = $attendances->map(function ($attendance) {
            return [
                'label' => $attendance->name . ' ' .
                    $attendance->academicClassCourse->name . ' ' .
                    $attendance->academicClassCourse->academicYear->name,
                'value' => $attendance->id,
            ];
        });

        return view('attendances.index', compact('attendances'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'attendance' => 'required|exists:attendances,id'
        ], [], [
            'attendance' => 'Jenis Presensi'
        ]);

        /** @var \App\Models\Attendance $attendance */
        $attendance = Attendance::find($request->attendance);

        if (! $attendance->is_open) {
            flash('Mohon maaf, Anda sudah terlambat.')->error();
        } else {
            $academicClassCourseStudent = $request->user()
                ->academicClassCourseStudents()
                ->where('academic_class_course_id', $attendance->academicClassCourse->id)
                ->first();

            if (! $academicClassCourseStudent) {
                flash('Mohon maaf, Anda bukan peserta kelas ini.')->error();
            } else {
                $userAttend = $attendance->academicClassCourseStudents()->find($academicClassCourseStudent);

                $message = "
                    <div class=\"divide-y divide-gray-400\">
                        <div class=\"" . (empty($attendance->message) ? '' : 'pb-4') . "\">
                            %s
                        </div>
                ";

                if (! empty($attendance->message)) {
                    $message .= "
                        <div class=\"pt-4\">
                            {$attendance->message}
                        </div>
                    ";
                }

                $message .= '</div>';

                if ($userAttend) {
                    flash(
                        sprintf($message, sprintf(
                            'Anda sudah melakukan presensi pukul %s.',
                            $userAttend->pivot->created_at->format('H:i')
                        ))
                    )->error();
                } else {
                    $attendance->academicClassCourseStudents()->attach($academicClassCourseStudent);

                    flash(sprintf($message, 'Berhasil melakukan presensi.'))->success();
                }
            }
        }

        return redirect()->back();
    }
}
