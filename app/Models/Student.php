<?php

namespace App\Models;

use App\Garages\Utility\Unique;
use Database\Factories\StudentProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Student extends Model implements HasMedia
{
    use HasFactory,
        InteractsWithMedia;

    public $timestamps = false;

    protected $guarded = [
        'accepted_at',
        'graduated_at',
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
        'declined_at' => 'datetime',
        'graduated_at' => 'datetime',
        'father_salary' => 'integer',
        'mother_salary' => 'integer',
        'wali_salary' => 'integer',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('akta_kelahiran')
            ->useDisk('ppdb_gdrive')
            ->singleFile();

        $this->addMediaCollection('kartu_keluarga')
            ->useDisk('ppdb_gdrive')
            ->singleFile();
    }

    public function setFatherNameAttribute($value)
    {
        $this->attributes['father_name'] = app('indoNameFormatter')->format($value);
    }

    public function setFatherPhoneAttribute($value)
    {
        if (! is_null($value)) {
            $value = preg_replace('/[^0-9]/', '', $value);
        }

        $this->attributes['father_phone'] = $value;
    }

    public function setMotherNameAttribute($value)
    {
        $this->attributes['mother_name'] = app('indoNameFormatter')->format($value);
    }

    public function setMotherPhoneAttribute($value)
    {
        if (! is_null($value)) {
            $value = preg_replace('/[^0-9]/', '', $value);
        }

        $this->attributes['mother_phone'] = $value;
    }

    public function setWaliNameAttribute($value)
    {
        $this->attributes['wali_name'] = app('indoNameFormatter')->format($value);
    }

    public function setWaliPhoneAttribute($value)
    {
        if (! is_null($value)) {
            $value = preg_replace('/[^0-9]/', '', $value);
        }

        $this->attributes['wali_phone'] = $value;
    }

    public function isPending(): bool
    {
        return ! ($this->isAccepted() || $this->isDeclined());
    }

    public function isAccepted(): bool
    {
        return ! is_null($this->getAttribute('accepted_at')) && ! $this->isDeclined();
    }

    public function isDeclined(): bool
    {
        return ! is_null($this->getAttribute('declined_at'));
    }

    public function isGraduated(): bool
    {
        return ! is_null($this->getAttribute('graduated_at'));
    }

    public static function generateNis(Site $site, $year = null)
    {
        $generate = function () use ($site, $year) {
            $prefix = $year
                    ? substr($year, 2, 4)
                    : (int) now()->format('y') + 1;

            return $prefix .
                str_pad((string) $site->id, 2, '0', STR_PAD_LEFT) .
                random_int(1000, 9999);
        };

        return Unique::generate(Student::class, $generate, 'nis');
    }

    protected static function newFactory(): StudentProfileFactory
    {
        return StudentProfileFactory::new();
    }
}
