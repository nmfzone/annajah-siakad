<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicClass extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function academicClassCourses()
    {
        return $this->hasMany(AcademicClassCourse::class);
    }
}
