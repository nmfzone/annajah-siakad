<?php

namespace App\Listeners\MediaLibrary;

use App\Garages\GoogleDrive\GoogleDriveAdapter;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAdded as Event;

class SaveFullPath
{
    public function handle(Event $event)
    {
        $storage = Storage::disk($event->media->disk);

        if ($storage->getDriver()->getAdapter() instanceof GoogleDriveAdapter) {
            $event->media->setCustomProperty(
                'full_path',
                $event->media->getCustomProperty('last_full_path')
            );
            $event->media->save();
        }
    }
}
