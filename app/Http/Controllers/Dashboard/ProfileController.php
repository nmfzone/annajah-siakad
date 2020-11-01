<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use HasSiteContext;

    public function __invoke(Request $request)
    {
        $user = $request->user();
        $this->userShouldBelongsToCurrentSite($user);
        $this->authorize('update', $user);

        return view('dashboard.profile.index', compact('user'));
    }
}