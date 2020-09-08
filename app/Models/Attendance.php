<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public static function generateSlug()
    {
        $generate = function () {
            return Str::random(20);
        };

        $slug = $generate();

        while (Attendance::whereSlug($slug)->first() != null) {
            $slug = $generate();
        }

        return $slug;
    }
}
