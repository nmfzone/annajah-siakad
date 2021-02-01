<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class PpdbRegistrationPage extends SubSitePage
{
    public function path(): string
    {
        return '/ppdb';
    }

    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->path());
    }

    public function elements(): array
    {
        return [
            '@element' => '#selector',
        ];
    }
}
