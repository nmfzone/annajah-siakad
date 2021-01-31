<?php

use App\Enums\Role;
use App\Http\Controllers\BackOffice\UsersController;

Route::get('/pengguna/buat', [UsersController::class, 'create'])
    ->name('users.create');

Route::post('/pengguna/buat', [UsersController::class, 'store'])
    ->name('users.store');

Route::get('/pengguna/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit');

Route::put('/pengguna/{user}/details', [UsersController::class, 'updateUserable'])
    ->name('users.update_userable');

Route::put('/pengguna/{user}', [UsersController::class, 'update'])
    ->name('users.update');

Route::delete('/pengguna/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy');

Route::get('/pengguna/all/{userType}', [UsersController::class, 'index'])
    ->name('users.index')
    ->where('userType', implode('|', array_merge(Role::ordinalRoles(), ['administrator\+editor'])));

Route::get('/pengguna/{user}', [UsersController::class, 'show'])
    ->name('users.show');
