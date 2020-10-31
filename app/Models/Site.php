<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Site extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $timestamps = false;

    protected $fillable = [
        'title', 'domain', 'address', 'phone', 'email', 'welcome_message',
        'facebook', 'twitter', 'instagram',
    ];

    protected $appends = [
        'logo'
    ];

    protected $with = [
        'media',
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

    public function getLogoAttribute()
    {
        $logo = $this->getFirstMediaUrl('logo');

        if (empty($logo)) {
            return asset('images/logo.png');
        }

        return $logo;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->acceptsMimeTypes(['image/jpeg', 'image/jpg', 'image/png'])
            ->singleFile();
    }
}