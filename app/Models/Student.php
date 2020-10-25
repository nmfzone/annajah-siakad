<?php

namespace App\Models;

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
}
