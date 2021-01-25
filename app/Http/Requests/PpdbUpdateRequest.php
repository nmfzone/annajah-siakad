<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;

class PpdbUpdateRequest extends PpdbCreateRequest
{
    public function authorize(): bool
    {
        return Gate::allows('update', $this->route('ppdb'));
    }

    public function rules(): array
    {
        $rules = parent::rules();

        return $this->mergeRules($rules, [
            //
        ]);
    }
}
