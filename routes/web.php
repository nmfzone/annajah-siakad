<?php

use App\Enums\Role;
use App\Http\Controllers\AttendancesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BackOffice\DashboardController;
use App\Http\Controllers\BackOffice\ProfileController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\ShortLinksController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\WebController;
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
    'wildcard_port' => false,
    'as' => 'main.',
], function () {
    Route::get('/', [WebController::class, 'index'])->name('web');

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::group([
        'as' => 'backoffice.',
        'middleware' => 'auth',
    ], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard')
            ->middleware(sprintf('role:%s,%s', Role::EDITOR, Role::SUPERADMIN));
    });
});

Route::group([
    'domain' => env('ASSETS_HOST', sprintf(
        '%s.%s',
        config('assets.sub_domain'),
        config('app.host')
    )),
    'wildcard_port' => false,
], function () {
    Route::get('/media/{type}/{conversion}/{path}', [StorageController::class, 'privateMedia'])
        ->middleware('auth')
        ->name('storage.private_media');
});

Route::get('/storage/{path}', [StorageController::class, 'index'])
    ->where(['path' => '.*'])
    ->name('storage.public');

Route::group([
    'domain' => '{sub_domain}{sub_domain_host}',
    'wildcard_port' => false,
    'as' => 'sub.',
    'middleware' => 'check_sub_domain',
], function () {
    Route::get('/', [WebController::class, 'index'])
        ->name('web');

    Route::get('/ppdb', [PpdbController::class, 'index'])
        ->name('ppdb.index');
    Route::post('/ppdb', [PpdbController::class, 'store'])
        ->middleware('guest')
        ->name('ppdb.store');

    Route::group([
        'as' => 'backoffice.',
        'prefix' => 'backoffice',
        'middleware' => ['auth', 'sub_permission'],
    ], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        require 'partials/backoffice/ppdbUser.php';
        require 'partials/backoffice/ppdb.php';
        require 'partials/backoffice/academicYear.php';
    });

    Route::get('/presensi', [AttendancesController::class, 'index'])
        ->name('attendances.index');
    Route::post('/presensi', [AttendancesController::class, 'store'])
        ->name('attendances.store');
});

Route::group([
    'as' => 'backoffice.',
    'prefix' => 'backoffice',
    'middleware' => ['auth', 'sub_permission'],
], function () {
    Route::get('/profil', ProfileController::class)
        ->name('profile');

    require 'partials/backoffice/article.php';
    require 'partials/backoffice/category.php';
    require 'partials/backoffice/user.php';
});

Route::get('/go/{code}', [ShortLinksController::class, 'show']);
