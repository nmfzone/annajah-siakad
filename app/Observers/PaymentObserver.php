<?php

namespace App\Observers;

use App\Enums\PaymentStatus;
use App\Models\Payment;

class PaymentObserver
{
    public function created(Payment $payment)
    {
        if ($payment->isVerified()) {
            $payment->transaction->update([
                'status' => PaymentStatus::PAID,
            ]);
        }
    }

    public function updated(Payment $payment)
    {
        if ($payment->isVerified()) {
            $payment->transaction->update([
                'status' => PaymentStatus::PAID,
            ]);
        }
    }
}
