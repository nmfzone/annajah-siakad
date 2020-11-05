<?php

namespace App\Observers;

use App\Models\TransactionItem;

class TransactionItemObserver
{
    public function created(TransactionItem $transactionItem)
    {
        $transactionItem->transaction->increment(
            'amount',
            $transactionItem->priceTotal()
        );
    }
}
