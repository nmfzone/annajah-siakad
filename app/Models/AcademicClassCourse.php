<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicClassCourse extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function students()
    {
        return $this->hasMany(AcademicClassCourseStudent::class);
    }

    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class);
    }
}
