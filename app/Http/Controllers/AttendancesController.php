<?php

namespace App\Http\Controllers;

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
        $this->middleware(['auth', 'role:student']);
    }

    public function index(Request $request)
    {
        /** @var \App\Models\Attendance $attendance */
        $attendances = Attendance::with('academicClass.academicYear')
            ->where('is_open', true)
            ->get();

        $attendances = $attendances->map(function ($attendance) {
            return [
                'label' => $attendance->name . ' ' .
                    $attendance->academicClass->name . ' ' .
                    $attendance->academicClass->academicYear->name,
                'value' => $attendance->id,
            ];
        });

        return view('attendances.index', compact('attendances'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'attendance' => 'required|exists:attendances,id'
        ]);

        /** @var \App\Models\Attendance $attendance */
        $attendance = Attendance::find($request->attendance);

        if (! $attendance->is_open) {
            flash('Mohon maaf, Anda sudah terlambat.')->error();
        } else {
            $academicClassStudent = $request->user()
                ->academicClassStudents()
                ->where('academic_class_id', $attendance->academicClass->id)
                ->first();

            if (! $academicClassStudent) {
                flash('Mohon maaf, Anda bukan peserta kelas ini.')->error();
            } else {
                $userAttend = $attendance->academicClassStudents()->find($academicClassStudent);

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
                    $attendance->academicClassStudents()->attach($academicClassStudent);

                    flash(sprintf($message, 'Berhasil melakukan presensi.'))->success();
                }
            }
        }

        return redirect()->back();
    }
}
