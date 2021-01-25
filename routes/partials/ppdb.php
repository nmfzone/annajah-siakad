<?php

Route::get('/ppdb', 'PpdbController@index')
    ->name('ppdb.index');

Route::get('/ppdb/buat', 'PpdbController@create')
    ->name('ppdb.create');

Route::post('/ppdb/buat', 'PpdbController@store')
    ->name('ppdb.store');

Route::get('/ppdb/{ppdb}/edit', 'PpdbController@edit')
    ->name('ppdb.edit');

Route::put('/ppdb/{ppdb}', 'PpdbController@update')
    ->name('ppdb.update');

Route::get('/ppdb/{ppdb}', 'PpdbController@show')
    ->name('ppdb.show');

Route::delete('/ppdb/{ppdb}', 'PpdbController@destroy')
    ->name('ppdb.destroy');
