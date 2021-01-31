<?php

use App\Http\Controllers\BackOffice\CategoriesController;

Route::get('/kategori', [CategoriesController::class, 'index'])
    ->name('categories.index');

Route::get('/kategori/buat', [CategoriesController::class, 'create'])
    ->name('categories.create');

Route::post('/kategori/buat', [CategoriesController::class, 'store'])
    ->name('categories.store');

Route::get('/kategori/{category}/edit', [CategoriesController::class, 'edit'])
    ->name('categories.edit');

Route::put('/kategori/{category}', [CategoriesController::class, 'update'])
    ->name('categories.update');

Route::get('/kategori/{category}', [CategoriesController::class, 'show'])
    ->name('categories.show');

Route::delete('/kategori/{category}', [CategoriesController::class, 'destroy'])
    ->name('categories.destroy');
