<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicClass extends Model
{
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
        return $this->hasMany(AcademicClassStudent::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
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
