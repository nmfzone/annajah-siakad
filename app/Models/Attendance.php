<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'type', 'is_open', 'started_at', 'ended_at',
    ];

    protected $casts = [
        'is_open' => 'boolean',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function academicClassStudents()
    {
        return $this->belongsToMany(AcademicClassStudent::class, 'attendance_record')
            ->withTimestamps();
    }

    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class);
    }
}
