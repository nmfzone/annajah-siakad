<?php

namespace App\Models;

use App\Enums\Role;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable,
        SoftDeletes;

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

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = app('indoNameFormatter')->format($value);
    }

    public function setPhoneAttribute($value)
    {
        $value = preg_replace('/[^0-9]/', '', $value);

        $this->attributes['phone'] = $value;
    }

    public function isAdmin()
    {
        return $this->role == Role::ADMIN;
    }

    public function isNotAdmin()
    {
        return ! $this->isAdmin();
    }

    public function isHeadMaster()
    {
        return $this->role == Role::HEAD_MASTER;
    }

    public function isNotHeadMatser()
    {
        return ! $this->isHeadMaster();
    }

    public function isTeacher()
    {
        return $this->role == Role::TEACHER;
    }

    public function isNotTeacher()
    {
        return ! $this->isTeacher();
    }

    public function isStudent()
    {
        return $this->role == Role::STUDENT;
    }

    public function isNotStudent()
    {
        return ! $this->isStudent();
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

        $index = User::where('role', $role)->count();
        $index = $index == 0 ? 1 : $index;
        $username = $generate($index);

        $i = 0;
        while (User::whereUsername($username)->first() != null) {
            $username = $generate($index++);

            if ($i++ == 10) {
                throw new Exception('Cannot generate unique Username.');
            }
        }

        return $username;
    }
}
