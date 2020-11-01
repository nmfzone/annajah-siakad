<?php

namespace App\Services;

use App\Models\Ppdb;
use App\Models\Site;

class PpdbService
{
    public function currentPpdb(): ?Ppdb
    {
        $ppdb = null;
        /** @var \App\Models\AcademicYear $academicYear */
        $academicYear = $this->site()->academicYears()
            ->orderBy('name', 'desc')
            ->first();

        if ($academicYear) {
            $ppdb = $academicYear->ppdb()
                ->latest()
                ->first();
        }

        return $ppdb;
    }

    protected static function site(): ?Site
    {
        $site = app()->make('site');

        return empty($site) ? null : $site;
    }
}
