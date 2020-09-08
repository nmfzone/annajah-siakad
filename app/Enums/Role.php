<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Role extends Enum
{
    const STUDENT = 'student';

    const TEACHER = 'teacher';

    const ADMIN = 'administrator';
}
