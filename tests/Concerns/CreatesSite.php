<?php

namespace Tests\Concerns;

use App\Models\Site;

trait CreatesSite
{
    public function createSubSite(): Site
    {
        /** @var \App\Models\Site $site */
        $site = Site::factory()->create([
            'domain' => 'smpit.' . config('app.host'),
        ]);

        $site->addMedia(resource_path('images/logo-smp.png'))
            ->preservingOriginal()
            ->toMediaCollection('logo');

        return $site;
    }
}
