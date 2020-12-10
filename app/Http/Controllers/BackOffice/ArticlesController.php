<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\ArticlesDataTable;
use App\Enums\ArticleType;
use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    use HasSiteContext;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Article::class);

        $datatable = new ArticlesDataTable(ArticleType::ARTICLE, $request->user());

        return $datatable->render('backoffice.articles.index');
    }

    public function create()
    {
        $this->authorize('create', Article::class);

        return view('backoffice.articles.create_or_update');
    }

    public function show(Article $article)
    {
        $this->articleShouldBelongsToCurrentSite($article);
        $this->authorize('view', $article);
        return view('backoffice.articles.show', compact('article'));
    }

    public function edit(Request $request, Article $article)
    {
        $this->articleShouldBelongsToCurrentSite($article);
        $this->authorize('update', $article);

        $articleResource = ArticleResource::make($article)->toArray($request);

        return view(
            'backoffice.articles.create_or_update',
            compact('article', 'articleResource')
        );
    }

    public function destroy(Article $article)
    {
        $this->articleShouldBelongsToCurrentSite($article);
        $this->authorize('delete', $article);

        $article->delete();
        flash('Berhasil menghapus artikel.')->success();

        return redirect()->route('backoffice.articles.index');
    }

    public function restore($id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        $this->articleShouldBelongsToCurrentSite($article);
        $this->authorize('restore', $article);

        $article->restore();
        flash('Berhasil mengembalikan artikel.')->success();

        return redirect()->back();
    }

    public function forceDelete($id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        $this->articleShouldBelongsToCurrentSite($article);
        $this->authorize('forceDelete', $article);

        $article->forceDelete();
        flash('Berhasil menghapus artikel secara permanen.')->success();

        return redirect()->back();
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
