<?php

namespace App\Garages\MediaLibrary\ResponsiveImages;

use App\Models\Media;
use Spatie\MediaLibrary\ResponsiveImages\RegisteredResponsiveImages as
    BaseRegisteredResponsiveImages;

class RegisteredResponsiveImages extends BaseRegisteredResponsiveImages
{
    public function __construct(Media $media, string $conversionName = '')
    {
        $this->media = $media;

        $this->generatedFor = $conversionName === ''
            ? 'media_library_original'
            : $conversionName;

        $this->files = collect($media->responsive_images[$this->generatedFor]['urls'] ?? [])
            ->map(fn (array $fileDetail) => new ResponsiveImage($fileDetail['name'], $fileDetail['path'], $media))
            ->filter(function (ResponsiveImage $responsiveImage) {
                return $responsiveImage->generatedFor() === $this->generatedFor;
            });
    }

    public function getUrls(): array
    {
        return $this->files
            ->map(fn (ResponsiveImage $responsiveImage) => $responsiveImage->url())
            ->values()
            ->toArray();
    }

    public function getSrcset(): string
    {
        $filesSrcset = $this->files
            ->map(function (ResponsiveImage $responsiveImage) {
                return "{$responsiveImage->url()} {$responsiveImage->width()}w";
            })
            ->implode(', ');

        $shouldAddPlaceholderSvg = config(
            'media-library.responsive_images.use_tiny_placeholders'
        ) && $this->getPlaceholderSvg();

        if ($shouldAddPlaceholderSvg) {
            $filesSrcset .= ', '.$this->getPlaceholderSvg().' 32w';
        }

        return $filesSrcset;
    }
}
