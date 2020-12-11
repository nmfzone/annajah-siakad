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

    public function isPending()
    {
        return $this->transaction->isPending();
    }

    public function isPaid()
    {
        return $this->transaction->isPaid();
    }

    public function isDeclined()
    {
        return $this->transaction->isDeclined();
    }

    public function priceTotal()
    {
        return $this->getAttribute('price') * $this->getAttribute('quantity');
    }

    public function priceFormatted()
    {
        return 'Rp ' . number_format($this->getAttribute('price'), 2, ',', '.');
    }

    public function priceTotalFormatted()
    {
        return 'Rp ' . number_format($this->priceTotal(), 2, ',', '.');
    }
}
