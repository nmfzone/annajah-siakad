<?php

namespace Tests\Browser\Pages;

use App\Models\Site;
use Laravel\Dusk\Page as BasePage;

abstract class SubSitePage extends BasePage
{
    protected $site;

    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    public function url(): string
    {
        $host = config('app.protocol') . '://' . $this->site->domain;

        return join_url($host, $this->path());
    }

    abstract public function path();
}
