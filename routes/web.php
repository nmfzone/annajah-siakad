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

Route::group([
    'domain' => config('app.host'),
    'as' => 'main.',
], function () {
    Route::get('/', 'WebController@index')->name('web');

    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');

    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::group([
        'namespace' => 'Dashboard',
        'middleware' => 'auth',
    ], function () {
        Route::get('/dashboard', 'DashboardController@index')
            ->name('dashboard')
            ->middleware(sprintf('role:%s,%s', Role::EDITOR, Role::SUPERADMIN));
    });
});

Route::group([
    'domain' => sprintf('{sub_domain}.%s', config('app.host')),
    'as' => 'sub.',
    'middleware' => 'check_sub_domain',
], function () {
    Route::get('/', 'WebController@index')->name('web');

    Route::group([
        'namespace' => 'Dashboard',
        'middleware' => ['auth', 'sub_permission'],
    ], function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

        Route::get('/pengguna/buat', 'UsersController@create')
            ->name('dashboard.users.create');
        Route::post('/pengguna/buat', 'UsersController@store')
            ->name('dashboard.users.store');
        Route::get('/pengguna/{user}/edit', 'UsersController@edit')
            ->name('dashboard.users.edit');
        Route::put('/pengguna/{user}', 'UsersController@update')
            ->name('dashboard.users.update');
        Route::delete('/pengguna/{user}', 'UsersController@destroy')
            ->name('dashboard.users.destroy');

        Route::get('/pengguna/all/{userType}', 'UsersController@index')
            ->name('dashboard.users.index')
            ->where('userType', implode('|', Role::ordinalRoles()));

        Route::get('/pengguna/{user}', 'UsersController@show')
            ->name('dashboard.users.show');
    });

    Route::get('/presensi', 'AttendancesController@index')->name('attendances.index');
    Route::post('/presensi', 'AttendancesController@store')->name('attendances.store');
});

Route::get('/go/{code}', 'ShortLinksController@show');
