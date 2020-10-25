<?php

namespace App\Models\Concerns;

use App\Enums\Role;

trait HasRole
{
    public function isSuperAdmin()
    {
        return $this->attributes['role'] == Role::SUPERADMIN;
    }

    public function isNotSuperAdmin()
    {
        return ! $this->isSuperAdmin();
    }

    public function isAdmin()
    {
        return $this->attributes['role'] == Role::ADMIN;
    }

    public function isNotAdmin()
    {
        return ! $this->isAdmin();
    }

    public function isHeadMaster()
    {
        return $this->attributes['role'] == Role::HEAD_MASTER;
    }

    public function isNotHeadMatser()
    {
        return ! $this->isHeadMaster();
    }

    public function isEditor()
    {
        return $this->attributes['role'] == Role::EDITOR;
    }

    public function isNotEditor()
    {
        return ! $this->isEditor();
    }

    public function isTeacher()
    {
        return $this->attributes['role'] == Role::TEACHER;
    }

    public function isNotTeacher()
    {
        return ! $this->isTeacher();
    }

    public function isStudent()
    {
        return $this->attributes['role'] == Role::STUDENT;
    }

    public function isNotStudent()
    {
        return ! $this->isStudent();
    }
}
