<?php

namespace App\Garages\MediaLibrary\ResponsiveImages;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\ResponsiveImages\ResponsiveImageGenerator as
    BaseResponsiveImageGenerator;
use Spatie\MediaLibrary\Support\ImageFactory;
use Spatie\TemporaryDirectory\TemporaryDirectory as BaseTemporaryDirectory;

class ResponsiveImageGenerator extends BaseResponsiveImageGenerator
{
    public function generateResponsiveImage(
        Media $media,
        string $baseImage,
        string $conversionName,
        int $targetWidth,
        BaseTemporaryDirectory $temporaryDirectory,
        int $conversionQuality = self::DEFAULT_CONVERSION_QUALITY
    ): void {
        $extension = $this->fileNamer->extensionFromBaseImage($baseImage);
        $responsiveImagePath = $this->fileNamer->temporaryFileName($media, $extension);

        $tempDestination = $temporaryDirectory->path($responsiveImagePath);

        ImageFactory::load($baseImage)
            ->optimize()
            ->width($targetWidth)
            ->quality($conversionQuality)
            ->save($tempDestination);

        $responsiveImageHeight = ImageFactory::load($tempDestination)->getHeight();

        // Users can customize the name like they want,
        // but we expect the last part in a certain format.
        $fileName = $this->addPropertiesToFileName(
            $responsiveImagePath,
            $conversionName,
            $targetWidth,
            $responsiveImageHeight,
            $extension
        );

        $responsiveImagePath = $temporaryDirectory->path($fileName);

        rename($tempDestination, $responsiveImagePath);

        $this->filesystem->copyToMediaLibrary($responsiveImagePath, $media, 'responsiveImages');

        ResponsiveImage::register($media, $fileName, $conversionName);
    }

    public function generateTinyJpg(
        Media $media,
        string $originalImagePath,
        string $conversionName,
        BaseTemporaryDirectory $temporaryDirectory
    ): void {
        $tempDestination = $temporaryDirectory->path('tiny.jpg');

        $this->tinyPlaceholderGenerator->generateTinyPlaceholder(
            $originalImagePath,
            $tempDestination
        );

        $this->guardAgainstInvalidTinyPlaceHolder($tempDestination);

        $tinyImageDataBase64 = base64_encode(file_get_contents($tempDestination));

        $tinyImageBase64 = 'data:image/jpeg;base64,'.$tinyImageDataBase64;

        $originalImage = ImageFactory::load($originalImagePath);

        $originalImageWidth = $originalImage->getWidth();

        $originalImageHeight = $originalImage->getHeight();

        $svg = view('media-library::placeholderSvg', compact(
            'originalImageWidth',
            'originalImageHeight',
            'tinyImageBase64'
        ));

        $base64Svg = 'data:image/svg+xml;base64,'.base64_encode($svg);

        ResponsiveImage::registerTinySvg($media, $base64Svg, $conversionName);
    }
}
