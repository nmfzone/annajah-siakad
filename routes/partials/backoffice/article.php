<?php

use App\Http\Controllers\BackOffice\ArticlesController;

Route::get('/artikel', [ArticlesController::class, 'index'])
    ->name('articles.index');

Route::get('/artikel/buat', [ArticlesController::class, 'create'])
    ->name('articles.create');

Route::get('/artikel/{article}/edit', [ArticlesController::class, 'edit'])
    ->name('articles.edit');

Route::get('/artikel/{article}', [ArticlesController::class, 'show'])
    ->name('articles.show');

Route::post('/artikel/{id}/restore', [ArticlesController::class, 'restore'])
    ->name('articles.restore');

Route::delete('/artikel/{article}', [ArticlesController::class, 'destroy'])
    ->name('articles.destroy');

Route::delete('/artikel/{id}/force', [ArticlesController::class, 'forceDelete'])
    ->name('articles.forceDelete');
