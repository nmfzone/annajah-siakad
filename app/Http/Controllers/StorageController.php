<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function index($path)
    {
        if (! Storage::exists($path)) {
            abort('404');
        }

        return Storage::response($path);
    }
}
