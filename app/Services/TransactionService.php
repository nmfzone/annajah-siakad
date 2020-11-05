<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Garages\Utility\Unique;
use App\Models\Transaction;
use Illuminate\Support\Str;

class TransactionService extends BaseService
{
    public function create(array $data): Transaction
    {
        return Transaction::create([
            'code' => $this->generateTransactionCode(),
            'payment_type' => $data['payment_type'],
            'provider' => $data['provider'],
            'provider_number' => $data['provider_number'],
            'provider_holder_name' => $data['provider_holder_name'],
            'valid_until' => $data['valid_until'],
            'status' => PaymentStatus::UNPAID,
        ]);
    }

    protected function generateTransactionCode(): string
    {
        $generate = function () {
            return sprintf(
                'TRX/%s/%s/%s',
                now()->format('y'),
                now()->format('m'),
                Str::randomPlus('numeric')
            );
        };

        return Unique::generate(Transaction::class, $generate, 'code');
    }
}
