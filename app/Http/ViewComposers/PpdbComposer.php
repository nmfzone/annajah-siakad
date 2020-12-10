<?php

namespace App\Http\ViewComposers;

use App\Services\PpdbService;
use Illuminate\View\View;

class PpdbComposer
{
    /**
     * @var \App\Services\PpdbService
     */
    protected $ppdbService;

    public function __construct(PpdbService $ppdbService)
    {
        $this->ppdbService = $ppdbService;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        if (! is_main_app()) {
            $view->with('currentPpdb', $this->ppdbService->currentPpdb());
        }

        /** @var \App\Models\User|null $authUser */
        $authUser = auth()->user();

        $view->with('latestPpdbUser', $authUser
            ? $this->ppdbService->latestPpdbUserFor($authUser)
            : null);
    }
}
