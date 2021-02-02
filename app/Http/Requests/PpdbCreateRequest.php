<?php

namespace App\Http\Requests;

use App\Enums\PaymentProvider;
use App\Enums\PaymentType;
use App\Models\AcademicYear;
use App\Models\Ppdb;
use Illuminate\Support\Arr;
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
                'date_format:"H:i"',
            ],
            'end_date' => [
                'required',
                'date_format:d-m-Y',
                'after:start_date'
            ],
            'end_time' => [
                'required',
                'date_format:"H:i"',
            ],
            'academic_year_id' => [
                'required',
                Rule::exists(AcademicYear::class, 'id')
                    ->where('site_id', (string) site()->id)
            ],
            'price' => [
                'required',
                'numeric',
            ],
            'payment' => [
                'required',
                'array',
            ],
            'payment.provider' => [
                'required',
                Rule::in(PaymentProvider::getValues()),
            ],
            'payment.payment_type' => [
                'required',
                Rule::in(
                    $this->isCashProvider()
                        ? [PaymentType::ON_THE_SPOT]
                        : PaymentType::getValuesExcept([PaymentType::ON_THE_SPOT])
                ),
            ],
            'payment.provider_number' => [
                'nullable',
                Rule::requiredIf(! $this->isCashProvider()),
                'numeric',
            ],
            'payment.provider_holder_name' => [
                'nullable',
                Rule::requiredIf(! $this->isCashProvider()),
                'string',
                'min:3',
                'max:50',
            ],
            'contact_persons' => [
                'required',
                'array',
                'min:1',
                'max:2',
            ],
            'contact_persons.*.name' => [
                'required',
                'string',
                'distinct',
                'min:3',
                'max:50',
            ],
            'contact_persons.*.number' => [
                'required',
                'distinct',
                'numeric',
            ],
        ];
    }

    public function validated(): array
    {
        $validated = parent::validated();

        $validated = array_merge($validated, [
            'started_at' => Carbon::createFromFormat(
                'd-m-Y H:i',
                $validated['start_date'] . ' ' . $validated['start_time']
            ),
            'ended_at' => Carbon::createFromFormat(
                'd-m-Y H:i',
                $validated['end_date'] . ' ' . $validated['end_time']
            ),
        ]);

        Arr::set(
            $validated,
            'payment.provider_holder_name',
            app('indoNameFormatter')->format(
                Arr::get($validated, 'payment.provider_holder_name')
            )
        );

        foreach (Arr::get($validated, 'contact_persons') as $key => $contactPerson) {
            Arr::set(
                $validated,
                sprintf('contact_persons.%s.name', $key),
                app('indoNameFormatter')->format(
                    $contactPerson['name']
                )
            );
        }

        return $validated;
    }

    public function attributes(): array
    {
        return [
            'start_date' => 'Tanggal Mulai PPDB',
            'start_time' => 'Waktu Mulai PPDB',
            'end_date' => 'Tanggal Selesai PPDB',
            'end_time' => 'Waktu Selesai PPDB',
            'academic_year_id' => 'Tahun Akademik',
            'price' => 'Biaya Pendaftaran',
            'payment' => 'Pembayaran',
            'payment.provider' => 'Nama Provider',
            'payment.payment_type' => 'Jenis Pembayaran',
            'payment.provider_number' => 'Nomor Provider',
            'payment.provider_holder_name' => 'Nama Pemilik Provider',
            'contact_persons' => 'Narahubung',
            'contact_persons.*.name' => 'Nama Narahubung',
            'contact_persons.*.number' => 'Nomor Narahubung',
        ];
    }

    protected function isCashProvider(): bool
    {
        return $this->input('payment.provider') === PaymentProvider::CASH;
    }
}
