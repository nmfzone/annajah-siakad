<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;

class ArticleUpdateRequest extends ArticleCreateRequest
{
    public function authorize()
    {
        return Gate::allows('update', $this->route('article'));
    }

    public function rules()
    {
        $rules = parent::rules();

        return $this->mergeRules($rules, [
            //
        ], ['type']);
    }
}
