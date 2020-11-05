<?php

namespace App\Observers;

use App\Models\AcademicClassCourse;

class AcademicClassCourseObserver
{
    public function creating(AcademicClassCourse $academicClassCourse)
    {
        $academicClassCourse->name = $academicClassCourse->academicClass->name
            . ' ' . $academicClassCourse->course->name;
    }
}
