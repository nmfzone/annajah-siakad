<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicYear extends Model
{
    use HasFactory,
        SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'from',
        'to',
        'site_id',
    ];

    public function academicClasses()
    {
        return $this->hasMany(AcademicClass::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function ppdb()
    {
        return $this->hasMany(Ppdb::class);
    }
}
