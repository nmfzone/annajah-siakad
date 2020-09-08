<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function academicClass()
    {
        return $this->hasMany(AcademicClass::class);
    }
}
