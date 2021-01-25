<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\PpdbDataTable;
use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Controllers\Controller;
use App\Http\Requests\PpdbCreateRequest;
use App\Http\Requests\PpdbUpdateRequest;
use App\Models\Ppdb;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PpdbController extends Controller
{
    use HasSiteContext;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Ppdb::class);

        $datatable = new PpdbDataTable();

        return $datatable->render('backoffice.ppdb.index');
    }

    public function create()
    {
        $this->authorize('create', Ppdb::class);

        return view('backoffice.ppdb.create');
    }

    public function store(PpdbCreateRequest $request)
    {
        Ppdb::create(Arr::only($request->validated(), [
            'started_at',
            'ended_at',
            'academic_year_id',
        ]));

        flash('Berhasil menambahkan PPDB.')->success();

        return redirect()->to(sub_route('backoffice.ppdb.index'));
    }

    public function show($subDomain, Ppdb $ppdb)
    {
        $this->ppdbShouldBelongsToCurrentSite($ppdb);
        $this->authorize('view', $ppdb);

        return view('backoffice.ppdb.show', compact('ppdb'));
    }

    public function edit($subDomain, Ppdb $ppdb)
    {
        $this->ppdbShouldBelongsToCurrentSite($ppdb);
        $this->authorize('update', $ppdb);

        return view('backoffice.ppdb.edit', compact('ppdb'));
    }

    public function update(PpdbUpdateRequest $request, $subDomain, Ppdb $ppdb)
    {
        $this->ppdbShouldBelongsToCurrentSite($ppdb);
        $ppdb->update(Arr::only($request->validated(), [
            'started_at',
            'ended_at',
            'academic_year_id',
        ]));

        flash('Berhasil memperbarui PPDB.')->success();

        return redirect()->to(sub_route('backoffice.ppdb.index'));
    }

    public function destroy($subDomain, Ppdb $ppdb)
    {
        $this->ppdbShouldBelongsToCurrentSite($ppdb);
        $this->authorize('delete', $ppdb);

        try {
            if ($ppdb->ppdbUsers()->count() > 0) {
                throw new Exception(
                    "PPDB cannot be deleted since it's referenced in another table."
                );
            }

            $ppdb->delete();
            flash('Berhasil menghapus PPDB.')->success();
        } catch (Exception $e) {
            flash(
                'Tidak dapat menghapus PPDB.<br>' .
                'Pastikan Anda telah menghapus semua hal yang berhubungan dengan ' .
                "PPDB {$ppdb->academicYear->name} terlebih dahulu."
            )->error();
        }

        return redirect()->to(sub_route('backoffice.ppdb.index'));
    }

    protected function ppdbShouldBelongsToCurrentSite(Ppdb $ppdb)
    {
        $site = site();

        if (is_null($site) && is_null($ppdb->academicYear->site)) {
            return;
        }

        if ((is_null($site) && ! is_null($ppdb->academicYear->site)) ||
            is_null($site->academicYears()->find($ppdb->academicYear))) {
            abort(404);
        }
    }
}
