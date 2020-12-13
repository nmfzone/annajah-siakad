<?php

namespace App\Garages\ImageOptimizer\Optimizers;

use App\Garages\ImageOptimizer\Image;

class Cwebp extends BaseOptimizer
{
    public $binaryName = 'cwebp';

    public function canHandle(Image $image): bool
    {
        return $image->mime() === 'image/webp';
    }

    public function getCommand(): array
    {
        return array_merge(
            [$this->binaryPath . $this->binaryName],
            $this->options,
            [
                $this->imagePath,
                '-o',
                $this->imagePath,
            ]
        );
    }
}
