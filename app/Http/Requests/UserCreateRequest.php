<?php

namespace App\Http\Requests;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', [User::class, $this->get('role')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:5|max:40',
            'email' => 'nullable|email',
            'password' => 'required|min:8|confirmed',
            'gender' => 'required|boolean',
            'phone' => 'nullable|digits_between:9,15',
            'birth_place' => 'string|min:3|max:40',
            'birth_date' => 'date|date_format:d-m-Y',
            'address' => 'max:120',
            'role' => ['required', Rule::in(Role::getValues())],
        ];
    }

    public function validated()
    {
        $validated = collect(parent::validated());

        $password = $validated->get('password');
        if (empty($password)) {
            $validated = $validated->except('password');
        } else {
            $validated->put('password', bcrypt($password));
        }

        return $validated->toArray();
    }
}
