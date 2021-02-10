<?php

namespace App\Listeners\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAdded as Event;

class SaveFullPath
{
    public function handle(Event $event)
    {
        $event->media->setCustomProperty(
            'full_path',
            $event->media->getCustomProperty('last_full_path')
        );
        $event->media->forgetCustomProperty('last_full_path');
        $event->media->save();
    }
}
