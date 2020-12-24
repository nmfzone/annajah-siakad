<?php

namespace App\Services;

use App\Garages\Utility\Unique;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ArticleService extends BaseService
{
    public function create(array $data, $isAutoDraft = false): Article
    {
        return Article::create([
            'slug' => $this->generateSlug($data['title'] ?? 'Untitled', $isAutoDraft),
            'title' => $data['title'],
            'type' => $data['type'],
            'content' => $data['content'],
            'published_at' => $data['published_at'] ?? null,
            'site_id' => $data['site_id'] ?? null,
            'user_id' => $data['user_id'],
        ]);
    }

    public function update(Article $article, array $data): Article
    {
        return tap($article)->update([
            'slug' => Str::slug(value_get($data, 'slug', $article->slug)),
            'title' => value_get($data, 'title', $article->content),
            'content' => value_get($data, 'content', $article->content),
            'published_at' => value_get($data, 'published_at', $article->published_at),
        ]);
    }

    public function getDefaultCategory(): Category
    {
        $key = 'articles.default-category';
        if ($category = Cache::get($key)) {
            return $category;
        }

        $category = Category::firstOrCreate([
            'slug' => 'uncategorized',
        ], [
            'name' => 'Uncategorized',
        ]);

        return Cache::rememberForever(
            $key,
            function () use ($category) {
                return $category;
            }
        );
    }

    public function getCategoryForStudent(): Category
    {
        $key = 'articles.student-category';
        if ($category = Cache::get($key)) {
            return $category;
        }

        $category = Category::firstOrCreate([
            'slug' => 'pojok-santri',
        ], [
            'name' => 'Pojok Santri',
        ]);

        return Cache::rememberForever(
            $key,
            function () use ($category) {
                return $category;
            }
        );
    }

    public function getCategoryForTeacher(): Category
    {
        $key = 'articles.teacher-category';
        if ($category = Cache::get($key)) {
            return $category;
        }

        $category = Category::firstOrCreate([
            'slug' => 'pojok-asatidz',
        ], [
            'name' => 'Pojok Asatidz',
        ]);

        return Cache::rememberForever(
            $key,
            function () use ($category) {
                return $category;
            }
        );
    }

    public function generateSlug($title, $isAutoDraft = false): string
    {
        $title = $isAutoDraft ? 'Konsep Otomatis' : $title;
        $slug = Str::slug($title);
        $prefix = $slug . '-';

        $count = Article::Where('slug', 'like', $prefix . '%')
            ->count();
        $count = $count == 0 ? -1 : $count;

        $generate = function ($index) use ($slug, $prefix) {
            return $index == 0 ? $slug : $prefix . $index;
        };

        return Unique::generate(Article::class, $generate, 'slug', $count);
    }
}
