<?php

namespace App\DataTables;

use App\Enums\Role;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    protected $authUser;

    protected $requestedType;

    public function __construct($authUser, $requestedType = null)
    {
        $this->authUser = $authUser;
        $this->requestedType = $requestedType ? strtolower($requestedType) : null;
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
            ->addColumn('action', function (User $user) {
                $authUser = optional(auth()->user());
                $deleteMessage = "Apakah Anda yakin ingin menghapus data {$user->role} ini?";

                $buttons = "<div class=\"btn-group btn-group-sm\">";

                $buttons .= "
                    <a href=\"" . route('dashboard.users.show', $user) . "\" class=\"btn btn-info\">
                      <i class=\"fas fa-eye\"></i>
                    </a>
                ";

                if ($authUser->isNotTeacher()) {
                    $buttons .= "
                        <a href=\"" . route('dashboard.users.edit', $user) . "\" class=\"btn btn-success\">
                          <i class=\"fas fa-edit\"></i>
                        </a>
                    ";

                    $buttons .= "
                        <a href=\"" . route('dashboard.users.destroy', $user) . "\"
                          class=\"btn btn-danger delete-this\"
                          data-message=\"" . $deleteMessage . "\">
                          <i class=\"fas fa-trash\"></i>
                        </a>
                    ";
                }

                return $buttons . '</div>';
            })
            ->editColumn('gender', function (User $user) {
                return $user->gender ? 'L' : 'P';
            });

        if ($this->requestedType == Role::STUDENT) {
            $datatables->editColumn('ttl', function (User $user) {
                if ($profile = $user->studentProfile) {
                    return optional($profile->birthDate)->format('d-m-Y');
                }

                return null;
            });
        }

        return $datatables;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        $query = $model->newQuery()
            ->with('studentProfile');

        if ($this->requestedType) {
            $query->where('role', $this->requestedType);
        }

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
            ->setTableId('users-table')
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
            Column::computed($indexColumn, 'No')
                ->exportable(false)
                ->printable(false),
            Column::make('name')
                ->title('Nama'),
            Column::make('username'),
            Column::make('gender')
                ->title('L/P'),
            Column::make('phone')
                ->title('No Telepon')
                ->content('-')
                ->hidden(),
            Column::computed('action', 'Aksi')
                ->width(100)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];

        if ($this->requestedType == Role::STUDENT) {
            $columns = array_merge($columns, [
                Column::make('studentProfile.birthDate', 'ttl')
                    ->title('TTL')
                    ->content('-')
                    ->hidden(),
            ]);
        }

        return $columns;
    }

    protected function filename()
    {
        $type = $this->requestedType ?? 'pengguna';

        return sprintf('SIAK_%s_Daftar_%s_%s', config('app.short_name'), $type, date('YmdHis'));
    }
}
