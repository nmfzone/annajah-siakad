<?php

namespace App\Services;

use App\Garages\Utility\Unique;
use App\Models\Article;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ArticleService extends BaseService
{
    public function create(array $data, $isAutoDraft = false): Article
    {
        $article = Article::create([
            'slug' => $this->generateSlug($data['title'] ?? 'Untitled', $isAutoDraft),
            'title' => $data['title'],
            'type' => $data['type'],
            'content' => $data['content'],
            'site_id' => Arr::get($data, 'site_id'),
            'user_id' => $data['user_id'],
        ]);

        return $article;
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
