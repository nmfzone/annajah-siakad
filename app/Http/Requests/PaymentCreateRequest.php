<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class PaymentCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows(
            'createPayment',
            [$this->route('ppdb_user'), $this->route('transaction')]
        );
    }

    public function rules(): array
    {
        return [
            'provider_holder_name' => 'required|max:50',
            'provider_number' => 'required|digits_between:5,30',
            'payment_date' => 'required|date_format:d-m-Y',
            'payment_time' => 'nullable|date_format:"H:i"',
            'proof_file' => 'required|file|mimes:png,jpg,jpeg|max:5000',
        ];
    }

    public function validated(): array
    {
        $validated = parent::validated();

        $validated['paid_on'] = Carbon::createFromFormat(
            'd-m-Y H:i',
            $validated['payment_date'] . ' ' .
            value_get($validated, 'payment_time', '00:00')
        );

        return $validated;
    }

    public function attributes(): array
    {
        return [
            'provider_holder_name' => 'Nama Pengirim',
            'provider_number' => 'Nomor Rekening',
            'payment_date' => 'Tanggal Pembayaran',
            'payment_time' => 'Waktu Pembayaran',
            'proof_file' => 'Bukti Pembayaran',
        ];
    }
}
