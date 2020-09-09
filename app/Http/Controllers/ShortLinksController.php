<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Illuminate\Http\Request;

class ShortLinksController extends Controller
{
    public function show(Request $request, $code)
    {
        $shortLink = ShortLink::whereCode($code)->firstOrFail();

        return view('redirect_link', compact('shortLink'));
    }
}
