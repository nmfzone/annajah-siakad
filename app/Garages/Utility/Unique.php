<?php

namespace App\Garages\Utility;

use Closure;
use Exception;

class Unique
{
    /**
     * Generate unique value for the given column of model.
     *
     * @param  string  $model
     * @param  \Closure  $generate
     * @param  string  $column
     * @param  int  $data
     * @param  mixed  $except
     * @param  string  $exceptColumn
     * @return string
     */
    public static function generate(
        $model,
        Closure $generate,
        $column = 'id',
        $data = 0,
        $except = null,
        $exceptColumn = 'id'
    ) {
        $code = $generate(++$data);

        $query = $model::where($column, $code);

        if (! is_null($except)) {
            $query->where($exceptColumn, '!=', $except);
        }

        $i = 0;
        while ($query->count() > 0) {
            $code = $generate($data + $i);

            if ($i++ == 10) {
                throw new Exception("Cannot generate unique $column.");
            }
        }

        return $code;
    }
}
