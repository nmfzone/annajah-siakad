<?php

namespace App\Models;

use App\Models\Concerns\HasRole;
use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravolt\Avatar\Facade as Avatar;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasRole,
        Notifiable,
        SoftDeletes,
        InteractsWithMedia;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'gender',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'gender' => 'boolean',
    ];

    protected $appends = [
        'avatar',
        'photo_url',
    ];

    protected $with = [
        'media',
    ];

    public function scopeForSite($query, Site $site = null): Builder
    {
        return $query->whereHas('sites', function ($query) use ($site) {
            if (is_null($site)) {
                return $query;
            }

            return $query->where('id', $site->id);
        });
    }

    public function academicClassCourseStudents()
    {
        return $this->hasMany(AcademicClassCourseStudent::class, 'student_id');
    }

    public function attendances()
    {
        return $this->belongsToMany(Attendance::class, 'attendance_record')
            ->withTimestamps();
    }

    public function sites()
    {
        return $this->belongsToMany(Site::class);
    }

    public function ppdb()
    {
        return $this->belongsToMany(Ppdb::class)
            ->using(PpdbUser::class)
            ->withTimestamps()
            ->withPivot('selection_method');
    }

    public function teacherProfiles()
    {
        return $this->morphedByMany(Teacher::class, 'userable')
            ->withPivot('site_id');
    }

    public function studentProfiles()
    {
        return $this->morphedByMany(Student::class, 'userable')
            ->withPivot('site_id');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = app('indoNameFormatter')->format($value);
    }

    public function setPhoneAttribute($value)
    {
        $value = preg_replace('/[^0-9]/', '', $value);

        $this->attributes['phone'] = $value;
    }

    public function getPhotoUrlAttribute()
    {
        $profileUrl = $this->getFirstMediaUrl('profile_pict');

        if (empty($profileUrl)) {
            return asset('images/user-default.png');
        }

        return $profileUrl;
    }

    public function getAvatarAttribute()
    {
        $avatar = $this->getFirstMediaUrl('profile_pict', 'thumb');

        if (empty($avatar)) {
            return Avatar::create($this->attributes['name'])->toBase64()->encoded;
        }

        return $avatar;
    }

    public function adminlteImage()
    {
        return $this->getAvatarAttribute();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_pict')
            ->acceptsMimeTypes(['image/jpeg', 'image/jpg', 'image/png'])
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(50)
                    ->height(50)
                    ->sharpen(10);
            });
    }

    public static function generateUsername($role)
    {
        $generate = function ($index) use ($role) {
            return 'annajah-' .
                now()->format('y') .
                str_pad($index, 3, '0', STR_PAD_LEFT);
        };

        $count = User::count();
        $username = $generate($count++);

        $i = 1;
        while (User::whereUsername($username)->first() != null) {
            $username = $generate($count + $i);

            if ($i++ == 10) {
                throw new Exception('Cannot generate unique Username.');
            }
        }

        return $username;
    }
}
