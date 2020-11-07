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

        Route::get('/profil', 'ProfileController')
            ->name('dashboard.profile');
    });
});

Route::group([
    'domain' => sprintf('%s.%s', config('assets.sub_domain'), config('app.host')),
], function () {
    Route::get('/media/{type}/{conversion}/{path}', 'StorageController@privateMedia')
        ->middleware('auth')
        ->name('storage.private_media');
});

Route::get('/storage/{path}', 'StorageController@index')
    ->where(['path' => '.*'])
    ->name('storage.public');

Route::group([
    'domain' => sprintf('{sub_domain}.%s', config('app.host')),
    'as' => 'sub.',
    'middleware' => 'check_sub_domain',
], function () {
    Route::get('/', 'WebController@index')
        ->name('web');

    Route::get('/ppdb', 'PpdbController@index')
        ->name('ppdb.index');
    Route::post('/ppdb', 'PpdbController@store')
        ->middleware('guest')
        ->name('ppdb.store');

    Route::group([
        'namespace' => 'Dashboard',
        'middleware' => ['auth', 'sub_permission'],
    ], function () {
        Route::get('/dashboard', 'DashboardController@index')
            ->name('dashboard');

        Route::get('/profil', 'ProfileController')
            ->name('dashboard.profile');

        Route::get('/ppdb/peserta', 'PpdbController@index')
            ->name('dashboard.ppdb.users.index');

        Route::get('/ppdb/peserta/detail', 'PpdbController@directShowUser')
            ->name('dashboard.ppdb.users.direct_show');

        Route::get('/ppdb/peserta/{ppdb_user}', 'PpdbController@showUser')
            ->name('dashboard.ppdb.users.show');

        Route::get(
            '/ppdb/peserta/{ppdb_user}/tagihan/{transaction}',
            'PpdbController@showPayment'
        )->name('dashboard.ppdb.users.show_payment');

        Route::post(
            '/ppdb/peserta/{ppdb_user}/tagihan/{transaction}',
            'PpdbController@storePayment'
        )->name('dashboard.ppdb.users.store_payment');

        Route::post(
            '/ppdb/peserta/{ppdb_user}/tagihan/{transaction}/accept',
            'PpdbController@acceptPayment'
        )->name('dashboard.ppdb.users.accept_payment');

        Route::post(
            '/ppdb/peserta/{ppdb_user}/tagihan/{transaction}/decline',
            'PpdbController@declinePayment'
        )->name('dashboard.ppdb.users.decline_payment');

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
