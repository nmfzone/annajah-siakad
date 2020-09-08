<?php

namespace App\Observers;

use App\Models\AcademicClass;

class AcademicClassObserver
{
    /**
     * Listen to the Academic Class creating event.
     *
     * @param  \App\Models\AcademicClass  $academicClass
     * @return void
     */
    public function creating(AcademicClass $academicClass)
    {
        $academicClass->name = $academicClass->class_name . ' ' . $academicClass->load('course')->course->name;
    }
}
