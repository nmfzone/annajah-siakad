<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\AcademicYearsDataTable;
use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicYearCreateRequest;
use App\Models\AcademicYear;
use Exception;
use Illuminate\Http\Request;

class AcademicYearsController extends Controller
{
    use HasSiteContext;

    public function index(Request $request)
    {
        $this->authorize('viewAny', AcademicYear::class);

        $datatable = new AcademicYearsDataTable();

        return $datatable->render('backoffice.academic_years.index');
    }

    public function create()
    {
        $this->authorize('create', AcademicYear::class);

        return view('backoffice.academic_years.create');
    }

    public function store(AcademicYearCreateRequest $request)
    {
        AcademicYear::create($request->validated());

        flash('Berhasil menambahkan tahun akademik.')->success();

        return redirect()->to(sub_route('backoffice.academic_years.index'));
    }

    public function show($subDomain, $subDomainHost, AcademicYear $academicYear)
    {
        $this->academicYearShouldBelongsToCurrentSite($academicYear);
        $this->authorize('view', $academicYear);

        return view('backoffice.academic_years.show', compact('academicYear'));
    }

    public function destroy($subDomain, $subDomainHost, AcademicYear $academicYear)
    {
        $this->academicYearShouldBelongsToCurrentSite($academicYear);
        $this->authorize('delete', $academicYear);

        try {
            if ($academicYear->academicClasses()->count() > 0 ||
                $academicYear->ppdb()->count() > 0
            ) {
                throw new Exception(
                    "Academic Year cannot be deleted since it's referenced in another tables."
                );
            }

            $academicYear->delete();
            flash('Berhasil menghapus tahun akademik.')->success();
        } catch (Exception $e) {
            flash(
                'Tidak dapat menghapus tahun akademik.<br>' .
                'Pastikan Anda telah menghapus semua hal yang berhubungan dengan ' .
                "Tahun Akademik {$academicYear->name} terlebih dahulu."
            )->error();
        }

        return redirect()->to(sub_route('backoffice.academic_years.index'));
    }

    protected function academicYearShouldBelongsToCurrentSite(AcademicYear $academicYear)
    {
        $site = site();

        if (is_null($site) && is_null($academicYear->site)) {
            return;
        }

        if ((is_null($site) && ! is_null($academicYear->site)) ||
            is_null($site->academicYears()->find($academicYear))) {
            abort(404);
        }
    }
}
