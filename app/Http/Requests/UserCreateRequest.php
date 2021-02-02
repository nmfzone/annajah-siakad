<?php

namespace App\Http\Requests;

use App\Enums\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UserCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('create', [User::class, $this->input('role')]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:40',
            'email' => 'nullable|email',
            'nickname' => 'nullable|string|min:3|max:15',
            'password' => 'required|min:8|confirmed',
            'gender' => 'required|boolean',
            'phone' => 'nullable|digits_between:9,15',
            'birth_place' => 'nullable|string|min:3|max:40',
            'birth_date' => 'nullable|date_format:d-m-Y',
            'address' => 'nullable|max:120',
            'role' => ['required', Rule::in(Role::getValues())],
        ];
    }

    public function validated(): array
    {
        $validated = parent::validated();

        $validated['password'] = bcrypt(Arr::get($validated, 'password'));

        if (! empty($validated['birth_date'])) {
            $validated['birth_date'] = Carbon::createFromFormat(
                'd-m-Y',
                $validated['birth_date']
            );
        }

        return $validated;
    }
}
