<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Payment extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function isVerified()
    {
        return ! is_null($this->verfied_at);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('proof')
            ->useDisk('local')
            ->singleFile();
    }
}
