<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class CreatePpdbPage extends SubSitePage
{
    public function path(): string
    {
        return '/backoffice/ppdb/buat';
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
