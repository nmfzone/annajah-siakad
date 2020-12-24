<?php

namespace App\Http\Controllers\Api\BackOffice;

use App\Http\Controllers\Api\Controller;
use App\Http\Controllers\Concerns\HasSiteContext;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    use HasSiteContext;

    public function index(Request $request)
    {
        $categories = Category::with('allChildren')
            ->whereNull('parent_id')
            ->where('site_id', optional(site())->id)
            ->paginate();

        return new CategoryCollection($categories);
    }
}
