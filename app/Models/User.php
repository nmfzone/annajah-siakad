<?php

namespace App\Models;

use App\Enums\Role;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPhoneAttribute($value)
    {
        $value = preg_replace('/[^0-9]/', '', $value);

        $this->attributes['phone'] = $value;
    }

    public function academicClassStudents()
    {
        return $this->hasMany(AcademicClassStudent::class, 'student_id');
    }

    public function attendances()
    {
        return $this->belongsToMany(Attendance::class, 'attendance_record')
            ->withTimestamps();
    }

    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class, 'student_id');
    }

    public static function generateUsername($role, $year = null)
    {
        $generate = function ($index) use ($role, $year) {
            if ($role == Role::STUDENT) {
                $year = $year ? $year : Carbon::now()->year;
                return $year . random_int(100000, 999999);
            }

            return 'annajah-' . $index;
        };

        $index = 1;
        $username = $generate($index);

        while (User::whereUsername($username)->first() != null) {
            $username = $generate($index++);
        }

        return $username;
    }
}
