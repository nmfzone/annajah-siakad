<?php

namespace App\Observers;

use App\Models\AcademicYear;

class AcademicYearObserver
{
    public function creating(AcademicYear $academicYear)
    {
        $academicYear->name = $academicYear->from . '/' . $academicYear->to;
    }
}
