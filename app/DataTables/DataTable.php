<?php

namespace App\DataTables;

use Illuminate\Support\Arr;
use Yajra\DataTables\Services\DataTable as BaseDataTable;

abstract class DataTable extends BaseDataTable
{
    public function isOrderedWithDefaultOrder(): bool
    {
        $htmlData = $this->html()->getAttributes();
        $requestData = $this->request()->all();

        return count(Arr::wrap(data_get($requestData, 'order'))) == 0 ||
            (data_get($htmlData, 'order.0.0') == data_get($requestData, 'order.0.column') &&
                data_get($htmlData, 'order.0.1') == data_get($requestData, 'order.0.dir'));
    }
}
