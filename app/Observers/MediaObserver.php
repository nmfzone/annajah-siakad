<?php

namespace App\Observers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\MediaCollections\Models\Observers\MediaObserver as BaseObserver;

class MediaObserver extends BaseObserver
{
    public function deleted(Media $media)
    {
        parent::deleted($media);

        // When the disk is GoogleDrive, Model delete will not working as expected.
        // We need to re-delete the model after deleted event is executed.
        Media::withoutEvents(function () use ($media) {
            $media->delete();
        });
    }
}
