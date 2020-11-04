<?php

namespace App\Models\Concerns;

use App\Models\Invoice;

trait Invoiceable
{
    /**
     * Get the model's invoice.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function invoice()
    {
        return $this->morphOne(Invoice::class, 'invoiceable');
    }

    /**
     * Get all of the model's invoices.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'invoiceable');
    }
}
