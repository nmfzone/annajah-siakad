<?php

namespace App\Garages\ImageOptimizer\Optimizers;

use App\Garages\ImageOptimizer\Image;

class Pngquant extends BaseOptimizer
{
    public $binaryName = 'pngquant';

    public function canHandle(Image $image): bool
    {
        return $image->mime() === 'image/png';
    }

    public function getCommand(): array
    {
        return array_merge(
            [$this->binaryPath . $this->binaryName],
            $this->options,
            [
                '--output',
                $this->imagePath,
            ]
        );
    }
}
