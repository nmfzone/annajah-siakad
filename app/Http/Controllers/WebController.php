<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasSiteContext;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class WebController extends Controller
{
    use HasSiteContext;

    public function index(Request $request)
    {
//        dd(Storage::disk('ppdb_gdrive')->getAdapter()->getCreatedFolders());
//        dd(Storage::disk('ppdb_gdrive')->allDirectories());
//        dd(Storage::disk('ppdb_gdrive')->deleteDirectory('./1F8brAksYwOCoUpNSNraTSm1hElUaYDrl'));
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

//        /** @var \App\Models\User $user */
//        $user = User::find(1);
//
//        dd(Media::find(2)->getUrl());
//
//        $adapter = Storage::disk('ppdb_gdrive')
//            ->getDriver()->getAdapter();
//        $folderId = '1aBBjaQXcOt0qquj--8VhAsj5_1zlUcE4';
//        $adapter->setPathPrefix($folderId);
//        $adapter->root = $folderId;
//
//        $user->addMedia(public_path('images/coba.jpg'))
//            ->preservingOriginal()
//            ->toMediaCollection('profile_pict');

        if (! is_main_app()) {
            $slides = [
                [
                    'id' => 3,
                    'image' => asset('images/slider-1.png')
                ],
                [
                    'id' => 1,
                    'image' => asset('images/slider-2.jpg')
                ],
            ];
            $articles = [
                [
                    'id' => 1,
                    'title' => 'Tantangan dunia Pendidikan di masa Pandemi',
                    'thumbnail' => asset('images/gambar-1.jpeg'),
                    'categories' => [
                        ['id' => 1, 'title' => 'Artikel', 'link' => '#']
                    ]
                ],
                [
                    'id' => 2,
                    'title' => 'Tantangan dunia Pendidikan di masa Pandemi',
                    'thumbnail' => asset('images/gambar-1.jpeg'),
                    'categories' => [
                        ['id' => 1, 'title' => 'Artikel', 'link' => '#']
                    ]
                ],
                [
                    'id' => 3,
                    'title' => 'Tantangan dunia Pendidikan di masa Pandemi',
                    'thumbnail' => asset('images/gambar-1.jpeg'),
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
