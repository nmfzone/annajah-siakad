<?php

namespace App\Observers;

use App\Models\Attendance;

class AttendanceObserver
{
    /**
     * Listen to the Attendance creating event.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return void
     */
    public function creating(Attendance $attendance)
    {
        $attendance->slug = Attendance::generateSlug();
    }
}
