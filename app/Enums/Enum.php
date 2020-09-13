<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum as BaseEnum;

abstract class Enum extends BaseEnum implements LocalizedEnum
{
    public static function getValuesExcept(array $excepts): array
    {
        return array_diff(array_values(static::getConstants()), $excepts);
    }

    public static function asSelectArrayExcepts(array $excepts): array
    {
        $array = array_diff(static::asArray(), $excepts);
        $selectArray = [];

        foreach ($array as $key => $value) {
            $selectArray[$value] = static::getDescription($value);
        }

        return $selectArray;
    }
}
