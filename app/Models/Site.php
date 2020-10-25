<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title', 'domain', 'address', 'phone', 'email', 'welcome_message',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function academicYears()
    {
        return $this->hasMany(AcademicYear::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
