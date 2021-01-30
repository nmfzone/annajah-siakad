<?php

namespace Tests\Concerns;

trait Helper
{
    public function pause(int $milliseconds): void
    {
        usleep($milliseconds * 1000);
    }
}
