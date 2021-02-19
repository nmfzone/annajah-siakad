<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasSiteContext;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Filesystem;
use App\Models\Media;

class WebController extends Controller
{
    use HasSiteContext;

    public function index(Request $request)
    {
//        dd(Storage::disk('ppdb_gdrive')->getAdapter()->getCreatedFolders());
//        dd(Storage::disk('ppdb_gdrive')->allDirectories());
//        dd(Storage::disk('ppdb_gdrive')->deleteDirectory('./1gJEKzduW1FtCIBgq0EKFd6OZuCH6-ou8'));
//        dd(Storage::disk('ppdb_gdrive')->createDir(
//            'PPDB 2020-2021',
//            [
//                'permission' => [
//                    'type' => 'user',
//                    'role' => 'reader',
//                    'emailAddress' => 'kurikulumannajah@gmail.com',
//                ]
//            ]
//        ), Storage::disk('ppdb_gdrive')->getAdapter()->getCreatedFolders());
//
//        /** @var \App\Models\User $user */
//        $user = User::findOrFail(4);
//        $student = $user->studentProfileFor(site());
//
//        /** @var \App\Models\Media $media */
//        $media = Media::findOrFail(2);
//        $media->delete();
//        dd('hai');
//        dd($media->delete());
//        dd($media->responsiveImages()->getUrls());
//
//        $adapter = Storage::disk('ppdb_gdrive')
//            ->getDriver()->getAdapter();
//        $folderId = '1vHl3JBvXWQttJiLzuXo1lP5gCqD8Zag-';
//        $adapter->setPathPrefix($folderId);
//        $adapter->root = $folderId;

//        $media->copy($student, 'akta_kelahiran');
//        $media->copy($user, 'profile_pict');
//
//        $user->addMedia(public_path('images/coba.jpg'))
//            ->preservingOriginal()
//            ->toMediaCollection('profile_pict', 'ppdb_gdrive');
//
//        $filesystem = app(Filesystem::class);
//        $filesystem->removeAllFiles($media);
//
//        dd('Success');

        if (! is_main_app()) {
            $slides = [
                [
                    'id' => 1,
                    'image' => asset('images/slider-1.png')
                ],
                [
                    'id' => 2,
                    'image' => asset('images/slider-2.webp')
                ],
                [
                    'id' => 3,
                    'image' => asset('images/slider-3.webp')
                ],
            ];
            $articles = [
                [
                    'id' => 1,
                    'title' => 'Tantangan dunia Pendidikan di masa Pandemi',
                    'thumbnail' => asset('images/gambar-1.webp'),
                    'categories' => [
                        ['id' => 1, 'title' => 'Artikel', 'link' => '#']
                    ]
                ],
                [
                    'id' => 2,
                    'title' => 'Tantangan dunia Pendidikan di masa Pandemi',
                    'thumbnail' => asset('images/gambar-1.webp'),
                    'categories' => [
                        ['id' => 1, 'title' => 'Artikel', 'link' => '#']
                    ]
                ],
                [
                    'id' => 3,
                    'title' => 'Tantangan dunia Pendidikan di masa Pandemi',
                    'thumbnail' => asset('images/gambar-1.webp'),
                    'categories' => [
                        ['id' => 1, 'title' => 'Artikel', 'link' => '#']
                    ]
                ]
            ];

            $viewName = sprintf('subs.%s.index', site()->id);

            if (! view()->exists($viewName)) {
                return view('main');
            }

            return view($viewName, compact('slides', 'articles'));
        }

        return view('main');
    }
}
