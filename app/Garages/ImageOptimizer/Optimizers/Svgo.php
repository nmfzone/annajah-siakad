<?php

namespace App\Garages\ImageOptimizer\Optimizers;

use App\Garages\ImageOptimizer\Image;

class Svgo extends BaseOptimizer
{
    public $binaryName = 'svgo';

    public function canHandle(Image $image): bool
    {
        if ($image->extension() !== 'svg') {
            return false;
        }

        return in_array($image->mime(), [
            'text/html',
            'image/svg',
            'image/svg+xml',
            'text/plain',
        ]);
    }

    public function getCommand(): array
    {
        return array_merge(
            [$this->binaryPath . $this->binaryName],
            $this->options,
            [
                '--input',
                $this->imagePath,
                '--output',
                $this->imagePath,
            ]
        );
    }
}
