<?php

namespace App\DataTables;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    protected $authUser;

    protected $requestedType;

    protected $site;

    public function __construct($authUser, $requestedType = null)
    {
        $this->authUser = $authUser;
        $this->requestedType = $requestedType ? strtolower($requestedType) : null;
        $this->site = site();
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $datatables = datatables($query)
            ->addIndexColumn()
            ->addColumn('action', function (User $user) {
                $deleteMessage = "Apakah Anda yakin ingin menghapus data {$user->role} ini?";

                $buttons = "<div class=\"btn-group btn-group-sm\">";

                $buttons .= "
                    <a href=\"" . route('backoffice.users.show', $user) . "\"
                      class=\"btn btn-info\">
                      <i class=\"fas fa-eye\"></i>
                    </a>
                ";

                if (Gate::allows('update', $user)) {
                    $buttons .= "
                        <a href=\"" . route('backoffice.users.edit', $user) . "\"
                          class=\"btn btn-success\">
                          <i class=\"fas fa-edit\"></i>
                        </a>
                    ";
                }

                if (Gate::allows('delete', $user)) {
                    $buttons .= "
                        <a href=\"" . route('backoffice.users.destroy', $user) . "\"
                          class=\"btn btn-danger delete-this\"
                          data-message=\"" . $deleteMessage . "\">
                          <i class=\"fas fa-trash\"></i>
                        </a>
                    ";
                }

                return $buttons . '</div>';
            })
            ->addColumn('gender', function (User $user) {
                return $user->gender ? 'L' : 'P';
            })
            ->editColumn('birth_date', function (User $user) {
                return optional($user->birth_date)->format('d-m-Y');
            });

        return $datatables;
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $query = User::query()
            ->with('studentProfiles', 'teacherProfiles');

        if ($this->requestedType) {
            $query->where(function (Builder $query) {
                if ($this->requestedType === 'administrator+editor') {
                    $query->where('role', Role::ADMIN)
                        ->orWhere('role', Role::EDITOR);
                } else {
                    $query->where('role', $this->requestedType);

                    if ($this->requestedType == Role::TEACHER) {
                        $query->orWhere('role', Role::HEAD_MASTER);
                    }
                }
            });
        }

        if ($this->site) {
            $query->whereHas('sites', function (Builder $query) {
                $query->where('id', $this->site->id);
            });
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
            ->responsive()
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
            Column::make('name')
                ->title('Nama'),
            Column::make('username'),
            Column::make('gender')
                ->title('L/P'),
            Column::make('phone')
                ->title('No Telepon')
                ->content('-')
                ->hidden(),
            Column::make('birth_place')
                ->title('Tempat Lahir')
                ->content('-')
                ->hidden(),
            Column::make('birth_date')
                ->title('Tanggal Lahir')
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
        $type = $this->requestedType ?? 'pengguna';

        return sprintf(
            'SIAK_%s_Daftar_%s_%s',
            config('app.short_name'),
            $type,
            date('YmdHis')
        );
    }
}
