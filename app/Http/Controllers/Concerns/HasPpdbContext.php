<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Ppdb;

trait HasPpdbContext
{
    protected function ppdbShouldBelongsToCurrentSite(Ppdb $ppdb)
    {
        $site = site();

        if (is_null($site) && is_null($ppdb->academicYear->site)) {
            return;
        }

        if ((is_null($site) && ! is_null($ppdb->academicYear->site)) ||
            is_null($site->academicYears()->find($ppdb->academicYear))) {
            abort(404);
        }
    }
}
