<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasSiteContext;
use App\Models\Site;
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

//        Site::find(1)->addMedia(public_path('images/logo-smp.png'))->toMediaCollection('logo');

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
                        'id' => 6,
                        'url' => '#',
                        'title' => 'Visi & Misi',
                    ],
                    ['id' => 7, 'url' => '#', 'title' => 'Sejarah'],
                ]
            ],
            [
                'id' => 3,
                'url' => '#',
                'title' => 'Kurikulum',
            ],
            [
                'id' => 4,
                'url' => '#',
                'title' => 'Kesiswaan',
            ],
            [
                'id' => 5,
                'url' => '#',
                'highlight' => true,
                'title' => 'PPDB',
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

            $viewName = sprintf('subs.%s.index', $site->id);

            if (! view()->exists($viewName)) {
                return abort(404);
            }

            return view($viewName, compact('slides', 'menus', 'site'));
        }

        return view('main');
    }
}
