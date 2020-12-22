<?php

namespace App\Http\Controllers\Concerns;

use App\Models\User;

trait HasSiteContext
{
    protected function userShouldBelongsToCurrentSite(User $user, $code = 404, $exceptSuperAdmin = false)
    {
        // @TODO: There is still a problem here. Fix it later.
        if ($exceptSuperAdmin && auth()->user()->isSuperAdmin()) {
            return;
        }

        if (! $this->isUserBelongsToCurrentSite($user)) {
            abort($code);
        }
    }

    protected function isUserBelongsToCurrentSite(User $user)
    {
        return ! is_null(site()->users()->find($user));
    }
}
