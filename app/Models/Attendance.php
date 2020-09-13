<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'name', 'type', 'is_open', 'started_at', 'ended_at',
        'advanced_started_at', 'advanced_ended_at',
    ];

    protected $casts = [
        'is_open' => 'boolean',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'advanced_started_at' => 'datetime',
        'advanced_ended_at' => 'datetime',
    ];

    public function academicClassStudents()
    {
        return $this->belongsToMany(AcademicClassStudent::class, 'attendance_record')
            ->withPivot('late')
            ->withTimestamps();
    }

    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class);
    }
}
