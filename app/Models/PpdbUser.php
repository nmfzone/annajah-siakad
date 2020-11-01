<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PpdbUser extends Pivot implements HasMedia
{
    use InteractsWithMedia;

    public $incrementing = true;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('bukti_pembayaran')
            ->useDisk('ppdb_gdrive')
            ->singleFile();
    }
}
