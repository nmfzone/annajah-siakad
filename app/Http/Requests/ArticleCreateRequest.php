<?php

namespace App\Http\Requests;

use App\Enums\ArticleType;
use App\Models\Article;
use App\Rules\RequiredIfEmpty;
use Illuminate\Support\Facades\Gate;

class ArticleCreateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('create', Article::class);
    }

    public function rules()
    {
        return [
            'type' => 'required|in:' . implode(',', ArticleType::getValues()),
            'title' => ['nullable', 'max:100', new RequiredIfEmpty('content')],
            'content' => ['nullable', 'string', new RequiredIfEmpty('title')],
            'published_at' => 'nullable|date',
        ];
    }

    public function validated()
    {
        $validated = collect(parent::validated());

        $validated->put('user_id', $this->user()->id);
        $validated->put('site_id', optional(site())->id);

        return $validated->toArray();
    }
}
