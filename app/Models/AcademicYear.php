<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicYear extends Model
{
    use SoftDeletes;

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

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
