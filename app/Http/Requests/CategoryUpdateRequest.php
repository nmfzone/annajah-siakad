<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends CategoryCreateRequest
{
    public function authorize(): bool
    {
        return Gate::allows('update', $this->route('category'));
    }

    public function rules(): array
    {
        /** @var \App\Models\Category $category */
        $category = $this->route('category');
        $rules = parent::rules();

        return $this->mergeRules($rules, [
            'slug' => $this->mergeRule($rules['slug'], [
                Rule::unique(Category::class, 'slug')
                    ->ignore($category),
            ], [3 => true]),
        ]);
    }

    public function validated(): array
    {
        /** @var \App\Models\Category $category */
        $category = $this->route('category');
        $validated = collect(parent::validated());

        $validated->put('slug', Str::slug(value_get($validated, 'slug', $category->slug)));

        return $validated->toArray();
    }
}
