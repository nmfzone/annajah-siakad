<?php

namespace App\Rules;

use App\Services\MediaService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class WysiwygMediaModel implements Rule
{
    protected $model;

    protected $service;

    public function __construct($model = null)
    {
        $this->model = $model;
        $this->service = app()->make(MediaService::class);
    }

    public function passes($attribute, $value)
    {
        if (is_null($this->model)) {
            return in_array($value, ['article'], true);
        }

        if (is_null($value)) {
            return true;
        }

        $model = $this->service->getModelForWysiwyg($this->model);
        $model = $model::query()->where('id', $value)->first();

        if (is_null($model)) {
            return false;
        }

        return Gate::allows('update', $model);
    }

    public function message()
    {
        if (is_null($this->model)) {
            return 'Invalid model.';
        }

        return 'Invalid model id.';
    }
}
