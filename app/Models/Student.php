<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Student extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $timestamps = false;

    protected $fillable = [
        'birth_date', 'father_name', 'mother_name',
        'father_phone', 'mother_phone', 'father_address', 'mother_address',
        'father_salary', 'mother_salary', 'previous_school',
        'previous_school_address',
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

    public static function generateNis(Site $site, $year = null)
    {
        $generate = function () use ($site, $year) {
            $year = $year ? $year : Carbon::now()->year;

            return $year .
                str_pad($site->id, 2, '0', STR_PAD_LEFT) .
                random_int(100000, 999999);
        };

        $nis = $generate();

        $i = 0;
        while (Student::whereNis($nis)->first() != null) {
            $nis = $generate();

            if ($i++ == 10) {
                throw new Exception('Cannot generate unique NIS.');
            }
        }

        return $nis;
    }
}
