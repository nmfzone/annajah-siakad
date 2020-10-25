<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicClassCourseStudent extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'number',
    ];

    public function attendances()
    {
        return $this->belongsToMany(Attendance::class, 'attendance_record')
            ->withPivot('late')
            ->withTimestamps();
    }

    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
