<?php

namespace App\Http\Controllers\Api\BackOffice;

use App\Http\Controllers\Api\Controller;
use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Resources\CategoryCollection;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleCategoriesController extends Controller
{
    use HasSiteContext;

    public function __invoke(Request $request, Article $article)
    {
        $data = $article->categories()
            ->with('parents')
            ->get();

        return new CategoryCollection($data);
    }
}
