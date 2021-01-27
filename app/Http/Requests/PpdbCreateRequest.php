<?php

namespace App\Http\Requests;

use App\Enums\PaymentProvider;
use App\Enums\PaymentType;
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
                Rule::in(PaymentType::getValues()),
            ],
            'payment.provider_number' => [
                'required',
                'numeric',
            ],
            'payment.provider_holder_name' => [
                'required',
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
                'min:3',
                'max:50',
            ],
            'contact_persons.*.number' => [
                'required',
                'numeric',
            ],
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
}
