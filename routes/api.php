<?php

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

Route::namespace('Api')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', 'CurrentUserController@show');

        Route::group([
            'namespace' => 'BackOffice',
            'as' => 'backoffice.',
            'middleware' => ['sub_permission'],
        ], function () {
            Route::post('/artikel', 'ArticlesController@store');
            Route::put('/artikel/{article}', 'ArticlesController@update');
            Route::get('/artikel/{article}/kategori', 'ArticleCategoriesController')
                ->name('articles.categoris.index');

            Route::get('/media/wysiwyg', 'MediaController@wysiwygMedia');
            Route::post('/media/wysiwyg', 'MediaController@storeWysiwygMedia');
        });
    });
});
