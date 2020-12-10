<?php

namespace App\Services;

use App\Enums\ArticleType;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class MediaService extends BaseService
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function generateSlug($type, $title, $isAutoDraft = false)
    {
        $model = $this->getModelForWysiwyg($type);

        if ($model === Article::class) {
            return $this->articleService->generateSlug($title, $isAutoDraft);
        }
    }

    public function createModelForWysiwyg(array $data, $type): Model
    {
        $model = $this->getModelForWysiwyg($type);

        if ($model === Article::class) {
            return $this->articleService->create([
                'type' => ArticleType::ARTICLE,
                'content' => '',
                'title' => 'Konsep Otomatis',
                'site_id' => optional(site())->id,
                'user_id' => auth()->user()->id,
            ], true);
        }
    }

    public function getModelForWysiwyg($type): string
    {
        if ($type === 'article') {
            return Article::class;
        }

        throw new InvalidArgumentException('Invalid model for the media.');
    }
}
