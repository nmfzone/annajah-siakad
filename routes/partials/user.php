<?php

use App\Enums\Role;

Route::get('/pengguna/buat', 'UsersController@create')
    ->name('users.create');

Route::post('/pengguna/buat', 'UsersController@store')
    ->name('users.store');

Route::get('/pengguna/{user}/edit', 'UsersController@edit')
    ->name('users.edit');

Route::put('/pengguna/{user}/details', 'UsersController@updateUserable')
    ->name('users.update_userable');

Route::put('/pengguna/{user}', 'UsersController@update')
    ->name('users.update');

Route::delete('/pengguna/{user}', 'UsersController@destroy')
    ->name('users.destroy');

Route::get('/pengguna/all/{userType}', 'UsersController@index')
    ->name('users.index')
    ->where('userType', implode('|', array_merge(Role::ordinalRoles(), ['administrator\+editor'])));

Route::get('/pengguna/{user}', 'UsersController@show')
    ->name('users.show');
