<?php

namespace App\Models;

use Glorand\Model\Settings\Traits\HasSettingsTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Site extends Model implements HasMedia
{
    use HasFactory,
        HasSettingsTable,
        InteractsWithMedia;

    public $timestamps = false;

    protected $guarded = [];

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

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function getLogoAttribute(): string
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

        $this->addMediaCollection('home_slides')
            ->acceptsMimeTypes(['image/jpeg', 'image/jpg', 'image/png']);

        $this->addMediaCollection('ppdb_slides')
            ->acceptsMimeTypes(['image/jpeg', 'image/jpg', 'image/png']);
    }
}
