<?php

namespace App\Http\Requests;

use App\Enums\ArticleType;
use App\Models\Article;
use App\Models\Media;
use App\Rules\RequiredIfEmpty;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ArticleCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('create', Article::class);
    }

    public function rules(): array
    {
        return [
            'type' => 'required|in:' . implode(',', ArticleType::getValues()),
            'title' => ['nullable', 'max:100', new RequiredIfEmpty('content')],
            'content' => ['nullable', 'string', new RequiredIfEmpty('title')],
            // @TODO: Correctly validate thumbnail id
            'thumbnail_id' => ['nullable', 'numeric', Rule::exists(Media::class, 'id')],
            'published_at' => 'nullable|date',
        ];
    }

    public function validated(): array
    {
        $validated = collect(parent::validated());

        $validated->put('user_id', $this->user()->id);
        $validated->put('site_id', optional(site())->id);

        return $validated->toArray();
    }
}
