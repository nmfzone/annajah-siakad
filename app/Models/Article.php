<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Article extends Model implements HasMedia
{
    use HasFactory,
        SoftDeletes,
        InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function thumbnail()
    {
        return $this->belongsTo(Media::class, 'thumbnail_id');
    }

    public function title(): string
    {
        $title = $this->getAttribute('title');

        return empty($title) ? '(tidak ada judul)' : $title;
    }

    public function isPublished(): bool
    {
        return ! is_null($this->getAttribute('published_at'));
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->useDisk('public');
    }
}
