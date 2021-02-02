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

        /** @var \App\Models\Ppdb $ppdb */
        $ppdb = $this->route('ppdb');
        $hasRegisteredUser = $ppdb->ppdbUsers()->exists();

        return $this->mergeRules($rules, [
            //
        ], [
            'academic_year_id' => $hasRegisteredUser
        ]);
    }
}
