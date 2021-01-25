<?php

namespace App\DataTables;

use App\Models\Ppdb;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Html\Column;

class PpdbDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addIndexColumn()
            ->addColumn('action', function (Ppdb $ppdb) {
                $buttons = "<div class=\"btn-group btn-group-sm\">";

                $buttons .= "
                    <a href=\"" .
                    sub_route('backoffice.ppdb.show', $ppdb) . "\"
                      class=\"btn btn-info\">
                      <i class=\"fas fa-eye\"></i>
                    </a>
                ";

                if (Gate::allows('update', $ppdb)) {
                    $buttons .= "
                        <a href=\"" . sub_route('backoffice.ppdb.edit', $ppdb) . "\"
                          class=\"btn btn-success\">
                          <i class=\"fas fa-edit\"></i>
                        </a>
                    ";
                }

                if (Gate::allows('delete', $ppdb)) {
                    $deleteMessage = "Apakah Anda yakin ingin menghapus PPDB ini?";

                    $buttons .= "
                        <a href=\"" . sub_route('backoffice.ppdb.destroy', $ppdb) . "\"
                          class=\"btn btn-danger delete-this\"
                          data-message=\"" . $deleteMessage . "\">
                          <i class=\"fas fa-trash\"></i>
                        </a>
                    ";
                }

                return $buttons . '</div>';
            })
            ->addColumn('name', function (Ppdb $ppdb) {
                return 'PPDB ' . $ppdb->academicYear->name;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $query = Ppdb::query()
            ->with('academicYear');

        if ($this->isOrderedWithDefaultOrder()) {
            $query->latest();
        }

        $query->whereHas('academicYear', function (Builder $query) {
            $query->where('site_id', site()->id);
        });

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('ppdb-table')
            ->addTableClass('table-striped')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('frtip')
            ->orderBy(0, 'desc')
            ->responsive()
            ->buttons([]);
    }

    protected function getColumns()
    {
        $indexColumn = config('datatables.index_column', 'DT_RowIndex');

        $columns = [
            Column::computed($indexColumn, 'No'),
            Column::computed('name')
                ->title('Nama'),
            Column::computed('action', 'Aksi')
                ->width(100)
                ->exportable(false)
                ->printable(false),
        ];

        return $columns;
    }
}
