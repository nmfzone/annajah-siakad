<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class CurrentUserController extends Controller
{
    /**
     * Display the logged in user data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function show(Request $request)
    {
        $user = $request->user();

        return UserResource::make($user);
    }
}
