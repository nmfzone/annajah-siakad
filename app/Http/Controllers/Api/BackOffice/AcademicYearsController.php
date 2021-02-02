<?php

namespace App\Http\Controllers\Api\BackOffice;

use App\Http\Controllers\Api\Controller;
use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Resources\AcademicYearCollection;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearsController extends Controller
{
    use HasSiteContext;

    public function index(Request $request)
    {
        $categories = AcademicYear::query()
            ->where('site_id', site()->id)
            ->orderByDesc('from');

        if (! empty($search = $request->input('q'))) {
            $categories->where('name', 'like', '%' . $search . '%');
        }

        return new AcademicYearCollection($categories->paginate());
    }
}
