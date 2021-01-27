<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\PpdbDataTable;
use App\Http\Controllers\Concerns\HasPpdbContext;
use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Controllers\Controller;
use App\Http\Requests\PpdbCreateRequest;
use App\Http\Requests\PpdbUpdateRequest;
use App\Models\Ppdb;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PpdbController extends Controller
{
    use HasSiteContext,
        HasPpdbContext;

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
        DB::transaction(function () use ($request) {
            $data = $request->validated();

            $ppdb = Ppdb::create(Arr::only($data, [
                'started_at',
                'ended_at',
                'academic_year_id',
            ]));

            $ppdb->settings()->setMultiple(Arr::only($data, [
                'price',
                'payment',
                'contact_persons',
            ]));
        });

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

        DB::transaction(function () use ($request, $ppdb) {
            $data = $request->validated();

            $ppdb->update(Arr::only($data, [
                'started_at',
                'ended_at',
                'academic_year_id',
            ]));

            $ppdb->settings()->setMultiple(Arr::only($data, [
                'price',
                'payment',
                'contact_persons',
            ]));
        });

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
}
