<?php

namespace App\Garages\MediaLibrary;

use App\Garages\GoogleDrive\GoogleDriveAdapter;
use App\Garages\Utility\ReflectionHelper;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator as PathGeneratorContracts;

class PathGenerator implements PathGeneratorContracts
{
    public function getPath(Media $media): string
    {
        return $this->getBasePath($media);
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getBasePath($media, 'conversions');
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getBasePath($media, 'responsive-images');
    }

    protected function getBasePath(Media $media, $type = null): string
    {
        [$adapter, $config] = $this->getAdapterAndConfig($media, $type);

        $saveModel = false;
        $path = $media->getKey() . '/';

        if ($adapter instanceof GoogleDriveAdapter) {
            $propertyName = 'gdrive_root_path';
            $path = $media->getCustomProperty($propertyName);

            if (! $path) {
                $path = $adapter->createDir($media->getKey(), $config)['path'] . '/';
                $media->setCustomProperty($propertyName, $path);
                $saveModel = true;
            }
        }

        if ($type) {
            if ($adapter instanceof GoogleDriveAdapter) {
                $propertyName = 'gdrive_' . $type . '_path';
                $tmpPath = $media->getCustomProperty($propertyName);

                if (! $tmpPath) {
                    $path = $adapter->createDir($path . $type, $config)['path'] . '/';
                    $media->setCustomProperty($propertyName, $path);
                    $saveModel = true;
                } else {
                    $path = $tmpPath;
                }
            } else {
                $path .= $type . '/';
            }
        }

        if ($saveModel) {
            $media->save();
        }

        return $path;
    }

    protected function getAdapterAndConfig(Media $media, $type = null)
    {
        $diskName = $media->disk;
        if ($type) {
            $diskName = $media->conversions_disk ?? $diskName;
        }

        $driver = Storage::disk($diskName)->getDriver();
        $adapter = $driver->getAdapter();
        $config = null;

        if ($adapter instanceof GoogleDriveAdapter) {
            $config = ReflectionHelper::callRestrictedMethod(
                $driver,
                'prepareConfig',
                [[]]
            );
        }

        return [$adapter, $config];
    }
}
