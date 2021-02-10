<?php

namespace App\Listeners\MediaLibrary;

use Spatie\MediaLibrary\Conversions\Events\ConversionHasBeenCompleted as Event;

class SaveConversionPath
{
    public function handle(Event $event)
    {
        $lastPath = $event->media->getCustomProperty('last_conversions_path');
        $conversionPaths = $event->media->getCustomProperty('conversion_paths', []);

        $conversionPaths[$event->conversion->getName()] = $lastPath;

        $event->media->setCustomProperty('conversion_paths', $conversionPaths);
        $event->media->forgetCustomProperty('last_conversions_path');
        $event->media->save();
    }
}
