<?php

namespace App\Garages\MediaLibrary\ResponsiveImages;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\ResponsiveImages\ResponsiveImage as BaseResponsiveImage;
use Spatie\MediaLibrary\Support\UrlGenerator\UrlGeneratorFactory;

class ResponsiveImage extends BaseResponsiveImage
{
    public string $path;

    public function __construct(string $fileName, string $path, Media $media)
    {
        $this->fileName = $fileName;
        $this->path = $path;
        $this->media = $media;
    }

    public static function register(Media $media, $fileName, $conversionName)
    {
        $responsiveImages = $media->responsive_images;

        $responsiveImages[$conversionName]['urls'][] = [
            'name' => $fileName,
            'path' => $media->getCustomProperty(
                'last_responsiveImages_path'
            ),
        ];

        $media->forgetCustomProperty('last_responsiveImages_path');

        $media->responsive_images = $responsiveImages;

        $media->save();
    }

    public function url(): string
    {
        $conversionName = '';

        if ($this->generatedFor() !== 'media_library_original') {
            $conversionName = $this->generatedFor();
        }

        $urlGenerator = UrlGeneratorFactory::createForMedia($this->media, $conversionName);

        return $urlGenerator->getResponsiveImageUrl($this->fileName);
    }
}
