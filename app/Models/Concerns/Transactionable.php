<?php

namespace App\Models\Concerns;

use App\Models\TransactionItem;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Transactionable
{
    public function transactionItem(): MorphOne
    {
        return $this->morphOne(TransactionItem::class, 'itemable');
    }

    public function transactionItems(): MorphMany
    {
        return $this->morphMany(TransactionItem::class, 'itemable');
    }
}
