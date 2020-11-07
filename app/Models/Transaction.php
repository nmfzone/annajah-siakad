<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    protected $casts = [
        'valid_until' => 'datetime',
        'amount' => 'float',
    ];

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function isPaid()
    {
        return $this->status === PaymentStatus::PAID;
    }

    public function isDeclined()
    {
        return $this->status === PaymentStatus::DECLINED;
    }

    public function amountFormatted()
    {
        return 'Rp ' . number_format($this->amount, 2, ',', '.');
    }
}
