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

            $site = $this->site();

            $viewName = sprintf('subs.%s.index', $site->id);

            if (! view()->exists($viewName)) {
                abort(404);
            }

            return view($viewName, compact('slides', 'articles'));
        }

        return view('main');
    }
}
