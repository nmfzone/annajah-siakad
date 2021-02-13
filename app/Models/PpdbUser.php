<?php

namespace App\Models;

use App\Models\Concerns\Transactionable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbUser extends Model
{
    use HasFactory,
        Transactionable;

    protected $fillable = [
        'user_id',
        'selection_method'
    ];

    public function ppdb()
    {
        return $this->belongsTo(Ppdb::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
