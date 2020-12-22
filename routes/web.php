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
        'namespace' => 'BackOffice',
        'as' => 'backoffice.',
        'middleware' => 'auth',
    ], function () {
        Route::get('/dashboard', 'DashboardController@index')
            ->name('dashboard')
            ->middleware(sprintf('role:%s,%s', Role::EDITOR, Role::SUPERADMIN));
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
        'namespace' => 'BackOffice',
        'as' => 'backoffice.',
        'middleware' => ['auth', 'sub_permission'],
    ], function () {
        Route::get('/dashboard', 'DashboardController@index')
            ->name('dashboard');

        require_once 'partials/ppdb.php';
    });

    Route::get('/presensi', 'AttendancesController@index')->name('attendances.index');
    Route::post('/presensi', 'AttendancesController@store')->name('attendances.store');
});

Route::group([
    'namespace' => 'BackOffice',
    'as' => 'backoffice.',
    'middleware' => ['auth', 'sub_permission'],
], function () {
    Route::get('/profil', 'ProfileController')
        ->name('profile');

    require_once 'partials/article.php';
    require_once 'partials/category.php';
    require_once 'partials/user.php';
});

Route::get('/go/{code}', 'ShortLinksController@show');
