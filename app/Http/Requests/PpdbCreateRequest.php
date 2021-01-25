<?php

namespace App\Http\Requests;

use App\Models\AcademicYear;
use App\Models\Ppdb;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class PpdbCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('create', Ppdb::class);
    }

    public function rules(): array
    {
        return [
            'start_date' => [
                'required',
                'date_format:d-m-Y',
            ],
            'start_time' => [
                'required',
                'date_format:H:i',
            ],
            'end_date' => [
                'required',
                'date_format:d-m-Y',
                'after:start_date'
            ],
            'end_time' => [
                'required',
                'date_format:H:i',
            ],
            'academic_year_id' => [
                'required',
                Rule::exists(AcademicYear::class, 'id')
                    ->where('site_id', (string) site()->id)
            ]
        ];
    }

    public function validated(): array
    {
        $validated = collect(parent::validated());

        $validated->put(
            'started_at',
            Carbon::createFromFormat(
                'd-m-Y H:i',
                $validated->get('start_date') . ' ' . $validated->get('start_time')
            )
        );

        $validated->put(
            'ended_at',
            Carbon::createFromFormat(
                'd-m-Y H:i',
                $validated->get('end_date') . ' ' . $validated->get('end_time')
            )
        );

        return $validated->toArray();
    }
}
