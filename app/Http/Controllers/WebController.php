<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasSiteContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebController extends Controller
{
    use HasSiteContext;

    public function index(Request $request)
    {
//        dd(Storage::disk('ppdb_gdrive')->getAdapter()->getCreatedFolders());
//        dd(Storage::disk('ppdb_gdrive')->allDirectories());
//        dd(Storage::disk('ppdb_gdrive')->deleteDirectory('./1VhpdeAMdO6HWqBUDGvbrUKzF8o9YRvPr'));
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

        $slides = [];

        $menus = [
            [
                'id' => 1,
                'url' => '#',
                'title' => 'Utama',
            ],
            [
                'id' => 2,
                'url' => '#',
                'title' => 'Profil',
                'children' => [
                    [
                        'id' => 5,
                        'url' => '#',
                        'title' => 'Visi & Misi',
                        'children' => [
                            ['id' => 7, 'url' => '#', 'title' => 'Visi & Misi Sejarah Akan Ditambahkan'],
                            ['id' => 8, 'url' => '#', 'title' => 'Sejarah'],
                            ['id' => 8, 'url' => '#', 'title' => 'Sejarah'],
                            ['id' => 8, 'url' => '#', 'title' => 'Sejarah'],
                            ['id' => 8, 'url' => '#', 'title' => 'Sejarah'],
                            ['id' => 8, 'url' => '#', 'title' => 'Sejarah'],
                        ]
                    ],
                    ['id' => 6, 'url' => '#', 'title' => 'Sejarah'],
                ]
            ],
            [
                'id' => 3,
                'url' => '#',
                'title' => 'Galeri',
            ],
            [
                'id' => 4,
                'url' => '#',
                'title' => 'Kontak',
            ],
        ];

        if (! is_main_app()) {
            $slides = [
                [
                    'id' => 3,
                    'image' => asset('images/car-1.jpg')
                ],
                [
                    'id' => 1,
                    'image' => asset('images/car-2.jpg')
                ],
            ];
            $site = $this->site();

            return view('subs.index', compact('slides', 'menus', 'site'));
        }

        return view('main');
    }
}
