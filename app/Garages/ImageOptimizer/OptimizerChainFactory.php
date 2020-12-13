<?php

namespace App\Garages\ImageOptimizer;

use App\Garages\ImageOptimizer\Optimizers\Cwebp;
use App\Garages\ImageOptimizer\Optimizers\Gifsicle;
use App\Garages\ImageOptimizer\Optimizers\Jpegoptim;
use App\Garages\ImageOptimizer\Optimizers\Optipng;
use App\Garages\ImageOptimizer\Optimizers\Pngquant;
use App\Garages\ImageOptimizer\Optimizers\Svgo;

class OptimizerChainFactory
{
    public static function create(array $config = []): OptimizerChain
    {
        $jpegQuality = '--max=85';
        $pngQuality = '--quality=85';
        if (isset($config['quality'])) {
            $jpegQuality = '--max='.$config['quality'];
            $pngQuality = '--quality='.$config['quality'];
        }

        return (new OptimizerChain())
            ->addOptimizer(new Jpegoptim([
                $jpegQuality,
                '--strip-all',
                '--all-progressive',
            ]))

            ->addOptimizer(new Pngquant([
                $pngQuality,
                '--force',
            ]))

            ->addOptimizer(new Optipng([
                '-i0',
                '-o2',
                '-quiet',
            ]))

            ->addOptimizer(new Svgo([
                '--disable={cleanupIDs,removeViewBox}',
            ]))

            ->addOptimizer(new Gifsicle([
                '-b',
                '-O3',
            ]))
            ->addOptimizer(new Cwebp([
                '-m',
                '6',
                '-pass',
                '10',
                '-mt',
                '-q',
                '80'
            ]));
    }
}
