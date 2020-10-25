<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Site;
use App\Models\User;

trait HasSiteContext
{
    protected function userShouldBelongsToCurrentSite(User $user, $code = 404)
    {
        if (! $this->isUserBelongsToCurrentSite($user)) {
            abort($code);
        }
    }

    protected function isUserBelongsToCurrentSite(User $user)
    {
        return ! is_null($this->site()->users()->find($user));
    }

    protected function site(): ?Site
    {
        $site = app()->make('site');

        return empty($site) ? null : $site;
    }
}
