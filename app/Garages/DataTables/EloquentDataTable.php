<?php

namespace App\Garages\DataTables;

use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\EloquentDataTable as BaseEloquentDataTable;

class EloquentDataTable extends BaseEloquentDataTable
{
    protected function performJoin($table, $foreign, $other, $type = 'left')
    {
        $joins = [];
        foreach ((array) $this->getBaseQueryBuilder()->joins as $key => $join) {
            $joins[] = $join->table;
        }

        if (! in_array($table, $joins)) {
            $query = $this->getBaseQueryBuilder();
            $query->select($query->from . '.*');
            $query->join($table, $foreign, '=', $other, $type);
            $columns = Schema::getColumnListing($table);

            foreach ($columns as $column) {
                $query->addSelect(sprintf('%s.%s as %s__%s', $table, $column, $table, $column));
            }
        }
    }
}
