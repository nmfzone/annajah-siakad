<?php

namespace App\Http\Controllers\Api\BackOffice;

use App\Http\Controllers\Api\Controller;
use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Requests\ArticleCreateRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Services\ArticleService;

class ArticlesController extends Controller
{
    use HasSiteContext;

    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function store(ArticleCreateRequest $request)
    {
        $article = $this->articleService->create([
            'type' => $request->get('type'),
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'site_id' => optional(site())->id,
            'user_id' => $request->user()->id,
        ]);

        return new ArticleResource($article);
    }

    public function update(ArticleUpdateRequest $request, Article $article)
    {
        $this->articleShouldBelongsToCurrentSite($article);

        $article->update($request->validated());

        return new ArticleResource($article);
    }

    protected function articleShouldBelongsToCurrentSite(Article $article)
    {
        $site = site();

        if (is_null($site) && is_null($article->site)) {
            return;
        }

        if ((is_null($site) && ! is_null($article->site)) || is_null($site->articles()->find($article))) {
            abort(404);
        }
    }
}
