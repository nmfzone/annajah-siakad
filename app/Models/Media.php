<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Filesystem;
use Spatie\MediaLibrary\MediaCollections\Models\Media as Model;
use Spatie\MediaLibrary\Support\TemporaryDirectory;

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

    public function copy(HasMedia $model, $collectionName = 'default', string $diskName = ''): Model
    {
        $temporaryDirectory = TemporaryDirectory::create();

        $temporaryFile = $temporaryDirectory->path('/').DIRECTORY_SEPARATOR.$this->file_name;

        /** @var \Spatie\MediaLibrary\MediaCollections\Filesystem $filesystem */
        $filesystem = app(Filesystem::class);

        $filesystem->copyFromMediaLibrary($this, $temporaryFile);

        $newMedia = $model
            ->addMedia($temporaryFile)
            ->usingName($this->name)
            ->withCustomProperties(Arr::except(
                $this->custom_properties,
                [ // exclude google drive specific custom properties
                    'gdrive_root_path',
                    'gdrive_responsive-images_path',
                    'gdrive_conversions_path',
                    'full_path',
                    'conversion_paths',
                    'last_responsiveImages_path',
                ]
            ))
            ->toMediaCollection($collectionName, $diskName);

        $temporaryDirectory->delete();

        return $newMedia;
    }
}
