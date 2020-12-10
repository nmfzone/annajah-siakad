<?php

namespace App\Models;

use Spatie\MediaLibrary\MediaCollections\Models\Media as Model;

class Media extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
