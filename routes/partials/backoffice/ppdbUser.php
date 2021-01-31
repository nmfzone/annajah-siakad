<?php

use App\Http\Controllers\BackOffice\ObservationController;
use App\Http\Controllers\BackOffice\PpdbUserController;

Route::get('/ppdb/{ppdb}/peserta', [PpdbUserController::class, 'index'])
    ->name('ppdb.users.index');

Route::get('/ppdb/peserta/detail', [PpdbUserController::class, 'directShow'])
    ->name('ppdb.users.direct_show');

Route::get('/ppdb/{ppdb}/peserta/{ppdb_user}', [PpdbUserController::class, 'show'])
    ->name('ppdb.users.show');

Route::get(
    '/ppdb/{ppdb}/peserta/{ppdb_user}/tagihan/{transaction}',
    [PpdbUserController::class, 'showPayment']
)->name('ppdb.users.show_payment');

Route::post(
    '/ppdb/{ppdb}/peserta/{ppdb_user}/tagihan/{transaction}',
    [PpdbUserController::class, 'storePayment']
)->name('ppdb.users.store_payment');

Route::post(
    '/ppdb/{ppdb}/peserta/{ppdb_user}/tagihan/{transaction}/accept',
    [PpdbUserController::class, 'acceptPayment']
)->name('ppdb.users.accept_payment');

Route::post(
    '/ppdb/{ppdb}/peserta/{ppdb_user}/tagihan/{transaction}/decline-or-cancel',
    [PpdbUserController::class, 'declineOrCancelPayment']
)->name('ppdb.users.decline_or_cancel_payment');

Route::post(
    '/ppdb/{ppdb}/peserta/{ppdb_user}/accept',
    [PpdbUserController::class, 'acceptAsStudent']
)->name('ppdb.users.accept');

Route::post(
    '/ppdb/{ppdb}/peserta/{ppdb_user}/decline-or-cancel',
    [PpdbUserController::class, 'declineOrCancelAsStudent']
)->name('ppdb.users.decline_or_cancel');

Route::get('/ppdb/observasi', [ObservationController::class, 'directShow'])
    ->name('ppdb.observation.direct_show');

Route::get('/ppdb/{ppdb}/peserta/{ppdb_user}/observasi', [ObservationController::class, 'show'])
    ->name('ppdb.observation.show');
