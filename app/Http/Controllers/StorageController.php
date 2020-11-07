<?php

namespace App\Http\Controllers;

use App\Garages\GoogleDrive\GoogleDriveAdapter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

    public function privateMedia(Request $request, $type, $conversion, $path)
    {
        $typeMap = [
            'n' => null, // normal
            'c' => 'conversions',
            'r' => 'responsive-images',
        ];

        try {
            if (! in_array($type, array_keys($typeMap))) {
                throw new Exception('Invalid private media type.');
            }

            $value = Crypt::decryptString($path);
            $values = explode(';', $value);

            if (Arr::get($values, 1) !== $type || Arr::get($values, 2) !== $conversion) {
                throw new Exception('Invalid private media path.');
            }

            /** @var \Spatie\MediaLibrary\MediaCollections\Models\Media $media */
            $media = Media::findOrFail($values[0]);
        } catch (Exception $e) {
            abort(404);
        }

        $conversion = $conversion === 'z' ? '' : $conversion;
        $type = $typeMap[$type];
        $conversionDiskName = $media->conversions_disk ?? $media->disk;
        $diskName = $conversion === '' ? $media->disk : $conversionDiskName;

        $storage = Storage::disk($diskName);
        $adapter = $storage->getDriver()->getAdapter();

        try {
            $path = $media->getPath($conversion);
        } catch (Exception $e) {
            abort(404);
        }

        if ($adapter instanceof GoogleDriveAdapter) {
            if ($conversion === '') {
                $path = $media->getCustomProperty('full_path');
            } else {
                $path = $media->getCustomProperty('conversion_paths.' . $conversion);
            }

            return Storage::disk($diskName)->response($path);
        }

        return response()->file($path);
    }
}
