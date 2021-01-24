<?php

namespace App\DataTables;

use App\Models\AcademicYear;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Html\Column;

class AcademicYearsDataTable extends DataTable
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
            ->addColumn('action', function (AcademicYear $academicYear) {
                $buttons = "<div class=\"btn-group btn-group-sm\">";

                $buttons .= "
                    <a href=\"" .
                    sub_route('backoffice.academic_years.show', $academicYear) . "\"
                      class=\"btn btn-info\">
                      <i class=\"fas fa-eye\"></i>
                    </a>
                ";

                if (Gate::allows('delete', $academicYear)) {
                    $deleteMessage = "Apakah Anda yakin ingin menghapus tahun akademik ini?";

                    $buttons .= "
                        <a href=\"" . sub_route('backoffice.academic_years.destroy', $academicYear) . "\"
                          class=\"btn btn-danger delete-this\"
                          data-message=\"" . $deleteMessage . "\">
                          <i class=\"fas fa-trash\"></i>
                        </a>
                    ";
                }

                return $buttons . '</div>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $query = AcademicYear::query();

        if ($this->isOrderedWithDefaultOrder()) {
            $query->orderByDesc('from');
        }

        $query->where('site_id', site()->id);

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
            ->setTableId('academic-years-table')
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
        $columns = [
            Column::computed('id')
                ->title('Index')
                ->printable(false)
                ->exportable(false)
                ->hidden(),
            Column::make('name')
                ->title('Nama'),
            Column::computed('action', 'Aksi')
                ->width(100)
                ->exportable(false)
                ->printable(false),
        ];

        return $columns;
    }
}
