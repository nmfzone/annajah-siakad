<?php

namespace App\Http\Controllers\Api\BackOffice;

use App\Http\Controllers\Api\Controller;
use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Requests\ArticleCreateRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

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
        $this->authorize('create', Article::class);
        /** @var \App\Models\User $authUser */
        $authUser = $request->user();

        $article = DB::transaction(function () use ($authUser, $request) {
            $requestData = $request->validated();
            $article = $this->articleService->create($requestData);

            // @TODO: Handle Head Master, etc.
            if ($authUser->isStudent()) {
                $category = $this->articleService->getCategoryForStudent();
                $category->articles()->save($article);
            } elseif ($authUser->isTeacher()) {
                $category = $this->articleService->getCategoryForTeacher();
                $category->articles()->save($article);
            } else {
                $categories = array_filter(Arr::wrap(Arr::get($requestData, 'categories')));

                if (empty($categories)) {
                    $categories = [$this->articleService->getDefaultCategory()->id];
                }

                $article->categories()->attach($categories);
            }

            return $article;
        });

        return new ArticleResource($article);
    }

    public function update(ArticleUpdateRequest $request, Article $article)
    {
        $this->articleShouldBelongsToCurrentSite($article);
        $this->authorize('update', $article);
        /** @var \App\Models\User $authUser */
        $authUser = $request->user();

        $article = DB::transaction(function () use ($authUser, $request, $article) {
            $requestData = $request->validated();
            $article = $this->articleService->update($article, $requestData);

            if (! ($authUser->isStudent() || $authUser->isTeacher())) {
                $categories = array_filter(Arr::wrap(Arr::get($requestData, 'categories')));

                if (empty($categories)) {
                    $categories = [$this->articleService->getDefaultCategory()->id];
                }

                $article->categories()->sync($categories);
            }

            return $article;
        });

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
