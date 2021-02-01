<?php

namespace App\Models;

use Glorand\Model\Settings\Traits\HasSettingsTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ppdb extends Model
{
    use HasFactory,
        HasSettingsTable;

    protected $table = 'ppdb';

    protected $guarded = [];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'is_open' => 'boolean',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function ppdbUsers()
    {
        return $this->hasMany(PpdbUser::class);
    }

    public function paymentDetails()
    {
        return $this->settings()->get('payment');
    }

    public function price()
    {
        return $this->settings()->get('price', 0);
    }

    public function priceFormatted()
    {
        return 'Rp ' . number_format($this->price(), 0, ',', '.');
    }

    public function isActive()
    {
        return $this->getAttribute('started_at')->lte(now()) &&
            $this->getAttribute('ended_at')->gte(now());
    }
}
