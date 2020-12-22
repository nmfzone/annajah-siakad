<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\CategoriesDataTable;
use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    use HasSiteContext;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Category::class);

        $datatable = new CategoriesDataTable();

        return $datatable->render('backoffice.categories.index');
    }

    public function create()
    {
        $this->authorize('create', Category::class);

        return view('backoffice.categories.create');
    }

    public function store(CategoryCreateRequest $request)
    {
        Category::create($request->validated());

        flash('Berhasil menambahkan kategori.')->success();

        return redirect()->route('backoffice.categories.index');
    }

    public function show(Category $category)
    {
        $this->categoryShouldBelongsToCurrentSite($category);
        $this->authorize('view', $category);

        return view('backoffice.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $this->categoryShouldBelongsToCurrentSite($category);
        $this->authorize('update', $category);

        return view('backoffice.categories.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $this->categoryShouldBelongsToCurrentSite($category);
        $category->update($request->validated());

        flash('Berhasil memperbarui kategori.')->success();

        return redirect()->route('backoffice.categories.index');
    }

    public function destroy(Category $category)
    {
        $this->categoryShouldBelongsToCurrentSite($category);
        $this->authorize('delete', $category);

        try {
            if ($category->slug === 'uncategorized') {
                throw new Exception('System Category cannot be deleted.');
            }

            $category->delete();
            flash('Berhasil menghapus kategory.')->success();
        } catch (Exception $e) {
            flash('Tidak dapat menghapus kategori.')->error();
        }

        return redirect()->route('backoffice.categories.index');
    }

    protected function categoryShouldBelongsToCurrentSite(Category $category)
    {
        $site = site();

        if (is_null($site) && is_null($category->site)) {
            return;
        }

        if ((is_null($site) && ! is_null($category->site)) ||
            is_null($site->categories()->find($category))) {
            abort(404);
        }
    }
}
