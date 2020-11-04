<?php

namespace App\Observers;

use App\Models\AcademicClassCourse;

class AcademicClassCourseObserver
{
    /**
     * Listen to the Academic Class Course creating event.
     *
     * @param  \App\Models\AcademicClassCourse  $academicClassCourse
     * @return void
     */
    public function creating(AcademicClassCourse $academicClassCourse)
    {
        $academicClassCourse->name = $academicClassCourse->academicClass->name
            . ' ' . $academicClassCourse->course->name;
    }
}
