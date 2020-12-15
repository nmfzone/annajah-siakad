<?php

namespace App\Services;

use App\Garages\Utility\Unique;
use App\Models\Article;
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
