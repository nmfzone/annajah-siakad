<?php

namespace App\Http\Requests;

use App\Models\AcademicYear;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class AcademicYearCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('create', AcademicYear::class);
    }

    public function rules(): array
    {
        return [
            'from' => [
                'date_format:Y',
                Rule::unique(AcademicYear::class, 'from')
            ],
            'to' => [
                'date_format:Y',
                'gt:from',
                Rule::unique(AcademicYear::class, 'to')
            ]
        ];
    }

    public function validated(): array
    {
        $validated = parent::validated();

        $validated['site_id'] = optional(site())->id;

        return $validated;
    }
}
