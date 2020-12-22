<?php

namespace App\DataTables;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CategoriesDataTable extends DataTable
{
    protected $site;

    public function __construct()
    {
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
        return datatables($query)
            ->addIndexColumn()
            ->addColumn('action', function (Category $category) {
                $buttons = "<div class=\"btn-group btn-group-sm\">";

                $buttons .= "
                    <a href=\"" .
                    route('backoffice.categories.show', $category) . "\"
                      class=\"btn btn-info\">
                      <i class=\"fas fa-eye\"></i>
                    </a>
                ";

                if (Gate::allows('update', $category)) {
                    $buttons .= "
                        <a href=\"" . route('backoffice.categories.edit', $category) . "\"
                          class=\"btn btn-success\">
                          <i class=\"fas fa-edit\"></i>
                        </a>
                    ";
                }

                if (Gate::allows('delete', $category)) {
                    $deleteMessage = "Apakah Anda yakin ingin menghapus kategori ini?";

                    $buttons .= "
                        <a href=\"" . route('backoffice.categories.destroy', $category) . "\"
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
        $query = Category::query()
            ->latest()
            ->with('articles');

        if ($this->site) {
            $query->where('site_id', $this->site->id);
        } else {
            $query->whereNull('site_id');
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
            ->setTableId('categories-table')
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
            Column::make('slug')
                ->title('Slug'),
            Column::make('name')
                ->title('Nama Kategori'),
            Column::computed('action', 'Aksi')
                ->width(100)
                ->exportable(false)
                ->printable(false),
        ];

        return $columns;
    }
}
