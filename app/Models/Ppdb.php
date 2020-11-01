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

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(PpdbUser::class)
            ->withTimestamps()
            ->withPivot('selection_method');
    }

    public function paymentLists()
    {
        return $this->settings()->get(PpdbSetting::PAYMENTS, []);
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
