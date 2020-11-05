<?php

namespace App\Models;

use App\Garages\Utility\Unique;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Student extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $timestamps = false;

    protected $guarded = [
        'accepted_at',
        'graduated_at',
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
            $prefix = $year
                    ? substr($year, 2, 4)
                    : (int) now()->format('y') + 1;

            return $prefix .
                str_pad((string) $site->id, 2, '0', STR_PAD_LEFT) .
                random_int(1000, 9999);
        };

        return Unique::generate(Student::class, $generate, 'nis');
    }
}
