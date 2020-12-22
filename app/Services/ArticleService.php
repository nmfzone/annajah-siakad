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
        $title = Str::slug($title);

        $count = Article::where('slug', $title)->orWhere('slug', 'like', $title . '-%')->count();
        $count = $count == 0 ? -1 : $count;

        $generate = function ($index) use ($title) {
            return $index == 0 ? $title : $title . '-' . $index;
        };

        return Unique::generate(Article::class, $generate, 'slug', $count);
    }
}
