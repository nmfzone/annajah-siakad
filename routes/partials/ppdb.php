<?php

Route::get('/ppdb/{ppdb}/peserta', 'PpdbUserController@index')
    ->name('ppdb.users.index');

Route::get('/ppdb/peserta/detail', 'PpdbUserController@directShow')
    ->name('ppdb.users.direct_show');

Route::get('/ppdb/{ppdb}/peserta/{ppdb_user}', 'PpdbUserController@show')
    ->name('ppdb.users.show');

Route::get(
    '/ppdb/{ppdb}/peserta/{ppdb_user}/tagihan/{transaction}',
    'PpdbUserController@showPayment'
)->name('ppdb.users.show_payment');

Route::post(
    '/ppdb/{ppdb}/peserta/{ppdb_user}/tagihan/{transaction}',
    'PpdbUserController@storePayment'
)->name('ppdb.users.store_payment');

Route::post(
    '/ppdb/{ppdb}/peserta/{ppdb_user}/tagihan/{transaction}/accept',
    'PpdbUserController@acceptPayment'
)->name('ppdb.users.accept_payment');

Route::post(
    '/ppdb/{ppdb}/peserta/{ppdb_user}/tagihan/{transaction}/decline-or-cancel',
    'PpdbUserController@declineOrCancelPayment'
)->name('ppdb.users.decline_or_cancel_payment');

Route::post(
    '/ppdb/{ppdb}/peserta/{ppdb_user}/accept',
    'PpdbUserController@acceptAsStudent'
)->name('ppdb.users.accept');

Route::post(
    '/ppdb/{ppdb}/peserta/{ppdb_user}/decline-or-cancel',
    'PpdbUserController@declineOrCancelAsStudent'
)->name('ppdb.users.decline_or_cancel');

Route::get('/ppdb/observasi', 'ObservationController@directShow')
    ->name('ppdb.observation.direct_show');

Route::get('/ppdb/{ppdb}/peserta/{ppdb_user}/observasi', 'ObservationController@show')
    ->name('ppdb.observation.show');
