<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $guarded = [];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'float',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function itemable()
    {
        return $this->morphTo();
    }

    public function isPending(): bool
    {
        return $this->transaction->isPending();
    }

    public function isPaid(): bool
    {
        return $this->transaction->isPaid();
    }

    public function isDeclined(): bool
    {
        return $this->transaction->isDeclined();
    }

    public function priceTotal(): int
    {
        return $this->getAttribute('price') * $this->getAttribute('quantity');
    }

    public function priceFormatted(): string
    {
        return 'Rp ' . number_format($this->getAttribute('price'), 2, ',', '.');
    }

    public function priceTotalFormatted(): string
    {
        return 'Rp ' . number_format($this->priceTotal(), 2, ',', '.');
    }
}
