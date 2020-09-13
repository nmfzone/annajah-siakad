<?php

use App\Enums\Role;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WebController@index');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['namespace' => 'Dashboard'], function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

        Route::get('/pengguna/buat', 'UsersController@create')
            ->name('dashboard.users.create')
            ->middleware(sprintf('role:%s', Role::ADMIN));
        Route::post('/pengguna/buat', 'UsersController@store')
            ->name('dashboard.users.store')
            ->middleware(sprintf('role:%s', Role::ADMIN));
        Route::get('/pengguna/{user}/edit', 'UsersController@edit')
            ->name('dashboard.users.edit')
            ->middleware(sprintf('role:%s', Role::ADMIN));
        Route::put('/pengguna/{user}', 'UsersController@update')
            ->name('dashboard.users.update')
            ->middleware(sprintf('role:%s', Role::ADMIN));
        Route::delete('/pengguna/{user}', 'UsersController@destroy')
            ->name('dashboard.users.destroy')
            ->middleware(sprintf('role:%s', Role::ADMIN));

        Route::get('/pengguna/all/{userType}', 'UsersController@index')
            ->name('dashboard.users.index')
            ->where('userType', implode('|', Role::asArray()))
            ->middleware(sprintf('except_role:%s', Role::STUDENT));

        Route::get('/pengguna/{user}', 'UsersController@show')
            ->name('dashboard.users.show')
            ->middleware(sprintf('except_role:%s', Role::STUDENT));
    });

    Route::get('/main', 'AttendancesController@index')->name('attendances.index');
    Route::post('/main', 'AttendancesController@store')->name('attendances.store');
});

Route::get('/go/{code}', 'ShortLinksController@show');
