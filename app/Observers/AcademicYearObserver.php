<?php

namespace App\Observers;

use App\Models\AcademicYear;

class AcademicYearObserver
{
    /**
     * Listen to the Academic Year creating event.
     *
     * @param  \App\Models\AcademicYear  $academicYear
     * @return void
     */
    public function creating(AcademicYear $academicYear)
    {
        $academicYear->name = $academicYear->from . '/' . $academicYear->to;
    }
}
