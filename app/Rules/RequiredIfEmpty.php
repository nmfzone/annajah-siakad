<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RequiredIfEmpty implements Rule
{
    protected $other;

    protected $request;

    public function __construct($other)
    {
        $this->other = $other;
        $this->request = request();
    }

    public function passes($attribute, $value)
    {
        if (empty($this->request->input($this->other))) {
            return ! empty($value);
        }

        return true;
    }

    public function message()
    {
        return sprintf('The :attribute is required when %s is empty.', $this->other);
    }
}
