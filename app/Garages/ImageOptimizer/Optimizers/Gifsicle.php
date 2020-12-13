<?php

namespace App\Garages\ImageOptimizer\Optimizers;

use App\Garages\ImageOptimizer\Image;

class Gifsicle extends BaseOptimizer
{
    public $binaryName = 'gifsicle';

    public function canHandle(Image $image): bool
    {
        return $image->mime() === 'image/gif';
    }

    public function getCommand(): array
    {
        return array_merge(
            [$this->binaryPath . $this->binaryName],
            $this->options,
            [
                '-i',
                $this->imagePath,
                '-o',
                $this->imagePath,
            ]
        );
    }
}
