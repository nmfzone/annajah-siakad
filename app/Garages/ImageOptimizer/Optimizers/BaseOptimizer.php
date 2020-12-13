<?php

namespace App\Garages\ImageOptimizer\Optimizers;

use App\Garages\ImageOptimizer\Optimizer;

abstract class BaseOptimizer implements Optimizer
{
    public $options = [];

    public $imagePath = '';

    public $binaryPath = '';

    public $binaryName = '';

    public function __construct($options = [])
    {
        $this->setOptions($options);
    }

    public function binaryName(): string
    {
        return $this->binaryName;
    }

    public function setBinaryPath(string $binaryPath)
    {
        if (strlen($binaryPath) > 0 && substr($binaryPath, -1) !== DIRECTORY_SEPARATOR) {
            $binaryPath = $binaryPath.DIRECTORY_SEPARATOR;
        }

        $this->binaryPath = $binaryPath;

        return $this;
    }

    public function setImagePath(string $imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    public function setOptions(array $options = [])
    {
        $this->options = $options;

        return $this;
    }

    public function getCommand(): array
    {
        return array_merge(
            [$this->binaryPath . $this->binaryName],
            $this->options,
            [$this->imagePath]
        );
    }
}
