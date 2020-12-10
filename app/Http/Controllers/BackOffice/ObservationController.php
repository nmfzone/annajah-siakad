<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Controllers\Controller;
use App\Models\Ppdb;
use App\Models\PpdbUser;
use App\Services\PpdbService;
use Illuminate\Http\Request;

class ObservationController extends Controller
{
    use HasSiteContext;

    protected $ppdbService;

    public function __construct(PpdbService $ppdbService)
    {
        $this->ppdbService = $ppdbService;
    }

    public function show(Request $request, $subDomain, Ppdb $ppdb, PpdbUser $ppdbUser)
    {
        $this->userShouldBelongsToPpdb($ppdb, $ppdbUser);

        return view('backoffice.ppdb.users.observation.show', compact('ppdbUser'));
    }

    public function directShow(Request $request, $subDomain)
    {
        /** @var \App\Models\User $authUser */
        $authUser = $request->user();

        $ppdbUser = $this->ppdbService->latestPpdbUserFor($authUser);

        if (is_null($ppdbUser)) {
            abort(404);
        }

        return view('backoffice.ppdb.users.observation.show', compact('ppdbUser'));
    }

    protected function userShouldBelongsToPpdb(Ppdb $ppdb, PpdbUser $ppdbUser)
    {
        if (! $ppdb->is($ppdbUser->ppdb)) {
            abort(404);
        }
    }
}
