<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use HasSiteContext;

    public function __invoke(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        $this->userShouldBelongsToCurrentSite($user, 404, true);
        $this->authorize('update', $user);
        $profileContext = true;

        return view('backoffice.users.edit', compact('user', 'profileContext'));
    }
}
