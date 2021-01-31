<?php

use App\Http\Controllers\BackOffice\PpdbController;

Route::get('/ppdb', [PpdbController::class, 'index'])
    ->name('ppdb.index');

Route::get('/ppdb/buat', [PpdbController::class, 'create'])
    ->name('ppdb.create');

Route::post('/ppdb/buat', [PpdbController::class, 'store'])
    ->name('ppdb.store');

Route::get('/ppdb/{ppdb}/edit', [PpdbController::class, 'edit'])
    ->name('ppdb.edit');

Route::put('/ppdb/{ppdb}', [PpdbController::class, 'update'])
    ->name('ppdb.update');

Route::get('/ppdb/{ppdb}', [PpdbController::class, 'show'])
    ->name('ppdb.show');

Route::delete('/ppdb/{ppdb}', [PpdbController::class, 'destroy'])
    ->name('ppdb.destroy');
