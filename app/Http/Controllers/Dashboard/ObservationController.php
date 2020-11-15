<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Controllers\Controller;
use App\Services\PpdbService;
use Illuminate\Http\Request;

class ObservationController extends Controller
{
    use HasSiteContext;

    /**
     * @var \App\Services\PpdbService
     */
    protected $ppdbService;

    public function __construct(PpdbService $ppdbService)
    {
        $this->ppdbService = $ppdbService;
    }

    public function index(Request $request)
    {
        /** @var \App\Models\User $authUser */
        $authUser = $request->user();

        if (! $authUser->isStudent()) {
            abort(403);
        }

        $ppdb = $this->ppdbService->currentPpdb();

        if (is_null($ppdb)) {
            abort(404);
        }

        return view('dashboard.ppdb.observation.index', compact('ppdb'));
    }
}
