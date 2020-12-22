<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
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
            ], [2 => true]),
        ]);
    }
}
