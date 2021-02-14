<?php

namespace App\Http\Requests;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserUpdateRequest extends UserCreateRequest
{
    public function authorize(): bool
    {
        return Gate::allows('update', $this->route('user'));
    }

    public function rules(): array
    {
        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();
        $rules = parent::rules();

        return $this->mergeRules($rules, [
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
        ], [
            'password' => empty($this->input('password')),
            // Cannot change role
            // @TODO: Handle head master change role to teacher.
            'role' => true,
        ]);
    }

    public function validated(): array
    {
        $validated = parent::validated();

        if (empty($this->input('password'))) {
            $validated = Arr::except($validated, 'password');
        }

        return $validated;
    }
}
