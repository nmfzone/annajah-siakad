<?php

namespace App\DataTables;

use App\Models\Ppdb;
use App\Models\PpdbUser;
use App\Models\Student;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PpdbUserDataTable extends DataTable
{
    /**
     * @var \App\Models\User|null
     */
    protected $authUser;

    /**
     * @var \App\Models\Ppdb
     */
    protected $ppdb;

    /**
     * @var \App\Models\Site
     */
    protected $site;

    public function __construct(Ppdb $ppdb)
    {
        $this->authUser = auth()->user();
        $this->ppdb = $ppdb;
        $this->site = $ppdb->academicYear->site;
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $datatables = datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (PpdbUser $ppdbUser) {
                $buttons = "<div class=\"btn-group btn-group-sm\">";

                $buttons .= "
                    <a href=\"" . sub_route('dashboard.ppdb.users.show', $ppdbUser) .
                        "\" class=\"btn btn-info\">
                      <i class=\"fas fa-eye\"></i>
                    </a>
                ";

                return $buttons . '</div>';
            })
            ->editColumn('user.gender', function (PpdbUser $ppdbUser) {
                return $ppdbUser->user->gender ? 'L' : 'P';
            });

        $datatables->addColumn('no_kk', function (PpdbUser $ppdbUser) {
            return optional($this->getStudentProfile($ppdbUser))->no_kk;
        });
        $datatables->addColumn('wali_name', function (PpdbUser $ppdbUser) {
            return optional($this->getStudentProfile($ppdbUser))->wali_name;
        });
        $datatables->addColumn('wali_phone', function (PpdbUser $ppdbUser) {
            return optional($this->getStudentProfile($ppdbUser))->wali_phone;
        });

        return $datatables;
    }

    protected function getStudentProfile(PpdbUser $ppdbUser): ?Student
    {
        return $ppdbUser->user->studentProfileFor($this->site);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $query = $this->ppdb
            ->ppdbUsers()
            ->whereHas('user')
            ->with('user.studentProfiles');

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
            ->setTableId('ppdb-user-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1, 'asc')
            ->buttons(
                Button::make('export'),
                Button::make('print')
            );
    }

    protected function getColumns()
    {
        $indexColumn = config('datatables.index_column', 'DT_RowIndex');

        $columns = [
            Column::computed($indexColumn, 'No'),
            Column::make('no_kk')
                ->title('No KK')
                ->content('-')
                ->hidden(),
            Column::make('user.name')
                ->title('Nama'),
            Column::make('user.username')
                ->title('Username'),
            Column::make('user.gender')
                ->title('L/P'),
            Column::make('wali_name')
                ->title('Nama Wali')
                ->content('-'),
            Column::make('wali_phone')
                ->title('No Telfon Wali')
                ->content('-')
                ->hidden(),
            Column::computed('action', 'Aksi')
                ->width(100)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];

        return $columns;
    }

    protected function filename()
    {
        return sprintf(
            'PPDB_%s_%s_Daftar_Santri_%s',
            $this->ppdb->academicYear->from,
            $this->ppdb->academicYear->to,
            date('YmdHis')
        );
    }
}
