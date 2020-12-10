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
        } elseif ($payment->isFraud()) {
            $payment->transaction->update([
                'status' => PaymentStatus::DECLINED,
            ]);
        } elseif ((! $payment->isVerified() && $payment->isVerifiedOriginal()) ||
            (! $payment->isFraud() && $payment->isFraudOriginal())) {
            $payment->transaction->update([
                'status' => PaymentStatus::UNPAID,
            ]);
        }
    }
}
