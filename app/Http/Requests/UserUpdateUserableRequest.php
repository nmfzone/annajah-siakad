<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;

class UserUpdateUserableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('updateUserable', $this->route('user'));
    }

    public function rules(): array
    {
        /** @var \App\Models\User $user */
        $user = $this->route('user');
        $rules = [];

        if ($user->isStudent()) {
            return $this->mergeRules($rules, [
                'no_kk' => 'required|digits_between:10,20',
                'previous_school' => 'required|string|min:10|max:50',
                'wali_name' => 'required|string|min:3|max:40',
                'wali_phone' => 'required|digits_between:9,20',
            ]);
        }

        return $this->mergeRules($rules, [
            //
        ]);
    }
}
