<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function academicClasses()
    {
        return $this->hasMany(AcademicClass::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
