<?php

namespace App\Models\Concerns;

use App\Models\TransactionItem;

trait Transactionable
{
    /**
     * Get the model's transaction item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function transactionItem()
    {
        return $this->morphOne(TransactionItem::class, 'itemable');
    }

    /**
     * Get all of the model's transaction items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function transactionItems()
    {
        return $this->morphMany(TransactionItem::class, 'itemable');
    }
}
