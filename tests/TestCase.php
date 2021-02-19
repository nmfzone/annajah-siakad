<?php

namespace Tests;

use App\Models\Site;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
        Storage::fake('public');
    }

    protected function getFullSubUrl(Site $site, $uri = null): string
    {
        $host = config('app.protocol') . '://' . $site->domain;

        if ($this->app->make('url')->isValidUrl($uri)) {
            return $uri;
        }

        return join_url($host, $uri);
    }
}
