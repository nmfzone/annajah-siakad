<?php

namespace App\Listeners\MediaLibrary;

use App\Garages\GoogleDrive\GoogleDriveAdapter;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\Conversions\Events\ConversionHasBeenCompleted as Event;

class SaveConversionPath
{
    public function handle(Event $event)
    {
        $conversionDiskName = $event->media->conversions_disk ?? $event->media->disk;
        $storage = Storage::disk($conversionDiskName);

        if ($storage->getDriver()->getAdapter() instanceof GoogleDriveAdapter) {
            $lastPath = $event->media->getCustomProperty('last_conversions_path');
            $conversionPaths = $event->media->getCustomProperty('conversion_paths', []);

            $conversionPaths[$event->conversion->getName()] = $lastPath;

            $event->media->setCustomProperty('conversion_paths', $conversionPaths);
            $event->media->save();
        }
    }
}
