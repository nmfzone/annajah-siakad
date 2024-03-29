<?php

namespace App\Garages\ImageOptimizer\Optimizers;

use App\Garages\ImageOptimizer\Image;

class Optipng extends BaseOptimizer
{
    public $binaryName = 'optipng';

    public function canHandle(Image $image): bool
    {
        return $image->mime() === 'image/png';
    }
}
