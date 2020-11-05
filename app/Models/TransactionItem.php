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

    public function isPaid()
    {
        return $this->transaction->isPaid();
    }

    public function priceTotal()
    {
        return $this->price * $this->quantity;
    }

    public function priceFormatted()
    {
        return 'Rp ' . number_format($this->price, 2, ',', '.');
    }

    public function priceTotalFormatted()
    {
        return 'Rp ' . number_format($this->priceTotal(), 2, ',', '.');
    }
}
