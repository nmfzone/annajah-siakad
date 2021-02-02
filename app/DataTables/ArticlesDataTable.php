<?php

namespace App\DataTables;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Html\Column;

class ArticlesDataTable extends DataTable
{
    /**
     * @var \App\Models\User|null
     */
    protected $authUser;

    protected $site;

    protected $type;

    public function __construct($type, User $authUser = null)
    {
        $this->type = $type;
        $this->authUser = $authUser;
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
            ->addColumn('action', function (Article $article) {
                $buttons = "<div class=\"btn-group btn-group-sm\">";

                if (! $article->trashed()) {
                    $buttons .= "
                        <a href=\"" .
                        route('backoffice.articles.show', $article) . "\"
                          class=\"btn btn-info\">
                          <i class=\"fas fa-eye\"></i>
                        </a>
                    ";

                    if (Gate::allows('update', $article)) {
                        $buttons .= "
                            <a href=\"" . route('backoffice.articles.edit', $article) . "\"
                              class=\"btn btn-success\">
                              <i class=\"fas fa-edit\"></i>
                            </a>
                        ";
                    }

                    if (Gate::allows('delete', $article)) {
                        $deleteMessage = "Apakah Anda yakin ingin menghapus artikel ini?";

                        $buttons .= "
                            <a href=\"" . route('backoffice.articles.destroy', $article) . "\"
                              class=\"btn btn-danger delete-this\"
                              data-message=\"" . $deleteMessage . "\">
                              <i class=\"fas fa-trash\"></i>
                            </a>
                        ";
                    }
                } else {
                    if (Gate::allows('restore', $article)) {
                        $confirmMessage = "Apakah Anda yakin akan mengembalikan artikel ini?";

                        $buttons .= "
                            <a href=\"" . route('backoffice.articles.restore', $article) . "\"
                              class=\"btn btn-warning submit-this\"
                              title=\"Batal Hapus\"
                              data-message=\"" . $confirmMessage . "\">
                              <i class=\"fas fa-undo\"></i>
                            </a>
                        ";
                    }

                    if (Gate::allows('forceDelete', $article)) {
                        $deleteMessage = "Apakah Anda yakin ingin menghapus artikel ini secara permanen?";

                        $buttons .= "
                            <a href=\"" . route('backoffice.articles.forceDelete', $article) . "\"
                              class=\"btn btn-danger delete-this\"
                              title=\"Hapus artikel secara permanen\"
                              data-message=\"" . $deleteMessage . "\">
                              <i class=\"fas fa-trash\"></i>
                            </a>
                        ";
                    }
                }

                return $buttons . '</div>';
            })
            ->editColumn('title', function (Article $article) {
                return $article->title();
            })
            ->addColumn('status', function (Article $article) {
                $status = ' <div class="badge badge-warning">Belum Terpublikasi</div>';

                if ($article->trashed()) {
                    $status = ' <div class="badge badge-danger">Terhapus</div>';
                } elseif ($article->isPublished()) {
                    $status = ' <div class="badge badge-success">Terpublikasi</div>';
                }

                return $status;
            })
            ->rawColumns(['status'], true);

        return $datatables;
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        /** @var \App\Models\User|\Illuminate\Support\Optional $authUser */
        $authUser = optional($this->authUser);
        $query = Article::query()
            ->with('author')
            ->where('type', $this->type);

        if ($this->isOrderedWithDefaultOrder()) {
            $query->latest();
        }

        if ($this->site) {
            $query->where('site_id', $this->site->id);
        } else {
            $query->whereNull('site_id');
        }

        if ($authUser->can('restore', Article::class)) {
            if ($this->request()->input('withTrashed')) {
                $query->withTrashed();
            } elseif ($this->request()->input('onlyTrashed')) {
                $query->onlyTrashed();
            }
        }

        if ($authUser->isNotSuperAdminOrAdmin()) {
            $query->where('user_id', $authUser->id);
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
            ->setTableId('articles-table')
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
            Column::make('title')
                ->title('Judul'),
            Column::computed('status')
                ->exportable(false)
                ->printable(false),
            Column::computed('action', 'Aksi')
                ->width(100)
                ->exportable(false)
                ->printable(false),
        ];

        return $columns;
    }
}
