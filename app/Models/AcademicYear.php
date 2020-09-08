<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'semester',
    ];

    protected $casts = [
        'semester' => 'integer',
    ];

    public function academicClasses()
    {
        return $this->hasMany(AcademicClass::class);
    }
}
