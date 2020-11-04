<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'is_open' => 'boolean',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'advanced_started_at' => 'datetime',
        'advanced_ended_at' => 'datetime',
    ];

    public function academicClassCourseStudents()
    {
        return $this->belongsToMany(AcademicClassCourseStudent::class, 'attendance_record')
            ->withPivot('is_late')
            ->withTimestamps();
    }

    public function academicClassCourse()
    {
        return $this->belongsTo(AcademicClassCourse::class);
    }
}
