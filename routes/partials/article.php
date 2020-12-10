<?php

Route::get('/artikel', 'ArticlesController@index')
    ->name('articles.index');

Route::get('/artikel/buat', 'ArticlesController@create')
    ->name('articles.create');

Route::get('/artikel/{article}/edit', 'ArticlesController@edit')
    ->name('articles.edit');

Route::get('/artikel/{article}', 'ArticlesController@show')
    ->name('articles.show');

Route::post('/artikel/{id}/restore', 'ArticlesController@restore')
    ->name('articles.restore');

Route::delete('/artikel/{article}', 'ArticlesController@destroy')
    ->name('articles.destroy');

Route::delete('/artikel/{id}/force', 'ArticlesController@forceDelete')
    ->name('articles.forceDelete');
