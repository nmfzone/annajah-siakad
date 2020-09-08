<?php

use Illuminate\Support\Facades\Route;
use App\Models\ShortLink;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['namespace' => 'Dashboard'], function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    });

    Route::get('/main', 'AttendancesController@index')->name('attendances.index');
    Route::post('/main', 'AttendancesController@store')->name('attendances.store');
});

Route::get('/go/{code}', function ($code) {
    $shortLink = ShortLink::whereCode($code)->firstOrFail();
    return view('redirect_link', compact('shortLink'));
});
