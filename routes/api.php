<?php

use App\Http\Controllers\Api\BackOffice\AcademicYearsController;
use App\Http\Controllers\Api\BackOffice\ArticleCategoriesController;
use App\Http\Controllers\Api\BackOffice\ArticlesController;
use App\Http\Controllers\Api\BackOffice\CategoriesController;
use App\Http\Controllers\Api\BackOffice\MediaController;
use App\Http\Controllers\Api\CurrentUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [CurrentUserController::class, 'show']);
});

Route::group([
    'domain' => '{sub_domain}{sub_domain_host}',
    'wildcard_port' => false,
    'as' => 'sub.',
    'middleware' => 'check_sub_domain',
], function () {
    Route::group([
        'middleware' => ['auth:sanctum', 'sub_permission'],
    ], function () {
        Route::get('/tahun-akademik', [AcademicYearsController::class, 'index']);
    });
});

Route::group([
    'middleware' => ['auth:sanctum', 'sub_permission'],
], function () {
    Route::post('/artikel', [ArticlesController::class, 'store']);
    Route::put('/artikel/{article}', [ArticlesController::class, 'update']);
    Route::get('/artikel/{article}/kategori', ArticleCategoriesController::class)
        ->name('articles.categoris.index');

    Route::get('/kategori', [CategoriesController::class, 'index']);

    Route::get('/media/wysiwyg', [MediaController::class, 'wysiwygMedia']);
    Route::post('/media/wysiwyg', [MediaController::class, 'storeWysiwygMedia']);
});
