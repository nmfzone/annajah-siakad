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

    public function index(Request $request, $slug)
    {
        /** @var \App\Models\Attendance $attendance */
        $attendance = Attendance::whereSlug($slug)->firstOrFail();
        /** @var \App\Models\AcademicClassStudent $academicClassStudent */
        $academicClassStudent = $request->user()
            ->academicClassStudents()
            ->where('academic_class_id', $attendance->academicClass->id)
            ->first();

        if (! $academicClassStudent) {
            abort(403, 'You don\'t belongs to this class.');
        }

        $userAttend = $attendance->academicClassStudents()->find($academicClassStudent);
        $attendTime = null;

        if ($userAttend) {
            $attendTime = $userAttend->pivot->created_at;
        }

        return view('attendances.index', compact('attendance', 'userAttend', 'attendTime'));
    }

    public function store(Request $request, $slug)
    {
        /** @var \App\Models\Attendance $attendance */
        $attendance = Attendance::whereSlug($slug)->firstOrFail();
        $academicClassStudent = $request->user()
            ->academicClassStudents()
            ->where('academic_class_id', $attendance->academicClass->id)
            ->first();

        if (! $academicClassStudent) {
            abort(403, 'You don\'t belongs to this class.');
        }

        $userAttend = $attendance->academicClassStudents()->find($academicClassStudent);

        if ($userAttend) {
            flash('Anda sudah melakukan presensi sebelumnya.')->error();
        } else {
            $attendance->academicClassStudents()->attach($academicClassStudent);
            flash('Berhasil melakukan presensi.')->success();
        }

        return redirect()->back();
    }
}
