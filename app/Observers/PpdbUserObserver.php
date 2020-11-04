<?php

namespace App\Observers;

use App\Enums\PaymentStatus;
use App\Garages\Utility\Unique;
use App\Models\Invoice;
use App\Models\PpdbUser;
use Illuminate\Support\Str;

class PpdbUserObserver
{
    /**
     * Listen to the Ppdb User created event.
     *
     * @param  \App\Models\PpdbUser  $ppdbUser
     * @return void
     */
    public function created(PpdbUser $ppdbUser)
    {
        $paymentDetails = $ppdbUser->ppdb->paymentDetails();

        $ppdbUser->invoices()->save(new Invoice([
            'name' => $this->generateInvoiceName(),
            'payment_type' => $paymentDetails['payment_type'],
            'provider' => $paymentDetails['provider'],
            'provider_number' => $paymentDetails['provider_number'],
            'provider_holder_name' => $paymentDetails['provider_holder_name'],
            'amount' => $ppdbUser->ppdb->paymentAmount(),
            'status' => PaymentStatus::UNPAID,
        ]));
    }

    protected function generateInvoiceName()
    {
        $generate = function () {
            return sprintf('TRX/PPDB/%s', Str::randomPlus('numeric'));
        };

        return Unique::generate(Invoice::class, $generate, 'name');
    }
}
