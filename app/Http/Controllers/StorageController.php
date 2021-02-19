<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
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

            $fileName = $values[3];
            $media = Media::findOrFail($values[0]);

            $conversion = $conversion === 'z' ? '' : $conversion;
            $type = $typeMap[$type];
            $conversionDiskName = $media->conversions_disk ?? $media->disk;
            $diskName = $conversion === '' && $type !== 'responsive-images'
                ? $media->disk
                : $conversionDiskName;

            if ($type === 'responsive-images') {
                $urls = collect(Arr::get(
                    $media->responsive_images,
                    ($conversion === '' ? 'media_library_original' : $conversion) . '.urls')
                );

                $path = $urls->filter(function (array $fileDetail) use ($fileName) {
                    return $fileDetail['name'] === $fileName;
                })->first()['path'];
            } else {
                if ($conversion === '') {
                    $path = $media->getCustomProperty('full_path');
                } else {
                    $path = Arr::get($media->generated_conversions, $conversion);
                }
            }

            return Storage::disk($diskName)->response($path);
        } catch (Exception $e) {
            abort(404);
        }
    }
}
