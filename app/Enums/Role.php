<?php

namespace App\Enums;

final class Role extends Enum
{
    const STUDENT = 'santri';

    const TEACHER = 'asatidz';

    const ADMIN = 'administrator';

    const HEAD_MASTER = 'head-master';

    const EDITOR = 'editor';

    const SUPERADMIN = 'superadmin';

    public static function createUserSelectArray(): array
    {
        return self::asSelectArrayExcepts([
            self::SUPERADMIN,
            self::ADMIN,
        ]);
    }

    public static function ordinalRoles(): array
    {
        return array_diff(static::asArray(), [
            self::SUPERADMIN,
        ]);
    }
}
