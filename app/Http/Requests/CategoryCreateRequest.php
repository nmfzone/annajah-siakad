<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class CategoryCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('create', Category::class);
    }

    public function rules(): array
    {
        return [
            'slug' => [
                'nullable',
                'alpha_dash',
                'max:100',
                Rule::unique(Category::class, 'slug')
            ],
            'name' => ['required', 'max:100'],
            'parent_id' => [
                'nullable',
                Rule::exists(Category::class, 'id')
                    ->where('site_id', optional(site())->id),
            ],
        ];
    }

    public function validated(): array
    {
        $validated = parent::validated();

        $validated['site_id'] = optional(site())->id;

        return $validated;
    }
}
