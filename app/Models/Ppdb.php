<?php

namespace App\Models;

use App\Enums\PpdbSetting;
use Glorand\Model\Settings\Traits\HasSettingsTable;
use Illuminate\Database\Eloquent\Model;

class Ppdb extends Model
{
    use HasSettingsTable;

    protected $table = 'ppdb';

    protected $fillable = [
        'started_at',
        'ended_at',
        'is_open',
    ];

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
        return $this->settings()->get(PpdbSetting::PAYMENT);
    }

    public function paymentAmount()
    {
        return $this->settings()->get(PpdbSetting::PAYMENT_AMOUNT, 0);
    }

    public function paymentAmountFormatted()
    {
        return 'Rp ' . number_format($this->paymentAmount(), 0, ',', '.');
    }
}
