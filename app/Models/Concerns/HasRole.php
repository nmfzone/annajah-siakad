<?php

namespace App\Models\Concerns;

use App\Enums\Role;

trait HasRole
{
    public function isSuperAdminOrAdmin(): bool
    {
        return $this->isSuperAdmin() || $this->isAdmin();
    }

    public function isNotSuperAdminOrAdmin(): bool
    {
        return ! $this->isSuperAdminOrAdmin();
    }

    public function isSuperAdmin(): bool
    {
        return $this->getAttribute('role') === Role::SUPERADMIN;
    }

    public function isNotSuperAdmin(): bool
    {
        return ! $this->isSuperAdmin();
    }

    public function isAdmin(): bool
    {
        return $this->getAttribute('role') === Role::ADMIN;
    }

    public function isNotAdmin(): bool
    {
        return ! $this->isAdmin();
    }

    public function isHeadMaster(): bool
    {
        return $this->getAttribute('role') === Role::HEAD_MASTER;
    }

    public function isNotHeadMatser(): bool
    {
        return ! $this->isHeadMaster();
    }

    public function isEditor(): bool
    {
        return $this->getAttribute('role') === Role::EDITOR;
    }

    public function isNotEditor(): bool
    {
        return ! $this->isEditor();
    }

    public function isTeacher(): bool
    {
        return $this->getAttribute('role') === Role::TEACHER;
    }

    public function isNotTeacher(): bool
    {
        return ! $this->isTeacher();
    }

    public function isStudent(): bool
    {
        return $this->getAttribute('role') === Role::STUDENT;
    }

    public function isNotStudent(): bool
    {
        return ! $this->isStudent();
    }
}
