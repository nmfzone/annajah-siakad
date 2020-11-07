<?php

namespace App\Models;

use App\Enums\PaymentFraudStatus;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Payment extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'verified_at' => 'datetime',
        'paid_on' => 'datetime',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function isVerified()
    {
        return ! is_null($this->verified_at);
    }

    public function isFraud()
    {
        return $this->fraud_status == PaymentFraudStatus::FRAUD;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('proof')
            ->useDisk('local')
            ->singleFile();
    }
}
