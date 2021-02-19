<?php

namespace App\Listeners\MediaLibrary;

use Spatie\MediaLibrary\Conversions\Events\ConversionHasBeenCompleted as Event;

class SaveConversionPath
{
    public function handle(Event $event)
    {
        $lastPath = $event->media->getCustomProperty('last_conversions_path');
        $generatedConversions = $event->media->generated_conversions;

        $generatedConversions[$event->conversion->getName()] = $lastPath;

        $event->media->generated_conversions = $generatedConversions;
        $event->media->forgetCustomProperty('last_conversions_path');
        $event->media->save();
    }
}
