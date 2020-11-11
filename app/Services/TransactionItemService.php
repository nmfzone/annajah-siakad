<?php

namespace App\Services;

use App\Garages\Utility\Unique;
use App\Models\PpdbUser;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use InvalidArgumentException;

class TransactionItemService extends BaseService
{
    protected $allowedItemable = [
        PpdbUser::class,
    ];

    public function create(Transaction $transaction, $itemable, array $data): TransactionItem
    {
        $this->checkItemable($itemable);

        return $itemable->transactionItem()->save(new TransactionItem([
            'code' => $this->generateInvoiceCode(),
            'name' => $data['name'],
            'quantity' => Arr::get($data, 'quantity', 1),
            'price' => $data['price'],
            'transaction_id' => $transaction->id,
        ]));
    }

    protected function checkItemable($itemable)
    {
        if (! is_object($itemable) || ! in_array(get_class($itemable), $this->allowedItemable)) {
            throw new InvalidArgumentException('Itemable is not allowed.');
        }
    }

    protected function generateInvoiceCode()
    {
        $generate = function () {
            return sprintf(
                'INV/%s/%s/%s',
                now()->format('y'),
                now()->format('m'),
                Str::randomPlus('numeric')
            );
        };

        return Unique::generate(TransactionItem::class, $generate, 'code');
    }
}
