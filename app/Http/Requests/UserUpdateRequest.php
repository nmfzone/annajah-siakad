<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;

class UserUpdateRequest extends UserCreateRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('update', $this->route('user'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /** @var \App\Models\User $authUser */
        $authUser = auth()->user();
        $rules = parent::rules();

        return $this->mergeRules($rules, [
            'password' => $this->mergeRule($rules['password'], ['nullable'], [0 => true]),
            'birth_place' => $this->mergeRule($rules['birth_place'], [
                'required' => $authUser->isStudent(),
            ], [
                0 => $authUser->isStudent(),
            ]),
            'birth_date' => $this->mergeRule($rules['birth_date'], [
                'required' => $authUser->isStudent(),
            ], [
                0 => $authUser->isStudent(),
            ]),
        ], ['role']);
    }
}
