<?php

use App\Models\Article;
use App\Models\Category;
use App\Models\Site;
use App\Services\ArticleService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ArticlesSeeder extends Seeder
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function run()
    {
        foreach (range(1, 50) as $item) {
            factory(Category::class)->create();
        }

        factory(Article::class, 50)
            ->create()
            ->each(function (Article $article) {
                $this->assignCategories($article);
            });

        Site::all()->each(function (Site $site) {
            factory(Article::class, 50)
                ->create([
                    'site_id' => $site->id,
                ])->each(function (Article $article) {
                    $this->assignCategories($article);
                });
        });
    }

    protected function assignCategories(Article $article)
    {
        $defaultCategory = $this->articleService->getDefaultCategory();

        if ($article->author->isTeacher()) {
            $category = $this->articleService->getCategoryForTeacher();
            $category->articles()->save($article);
        } elseif ($article->author->isStudent()) {
            $category = $this->articleService->getCategoryForStudent();
            $category->articles()->save($article);
        } else {
            $categories = Arr::random([
                [$defaultCategory->id],
                Category::inRandomOrder()
                    ->where('site_id', optional($article->site)->id)
                    ->take(rand(1, 4))
                    ->get()
                    ->pluck('id')
                    ->toArray(),
            ]);
            $article->categories()->attach($categories);
        }
    }
}
