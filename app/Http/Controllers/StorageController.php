<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function index($path)
    {
        $storage = Storage::disk('public');

        if (! $storage->exists($path)) {
            abort(404);
        }

        return $storage->response($path);
    }
}
