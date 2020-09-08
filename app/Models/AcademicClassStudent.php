<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicClassStudent extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'number',
    ];

    public function attendances()
    {
        return $this->belongsToMany(Attendance::class, 'attendance_record');
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
