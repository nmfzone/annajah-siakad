<?php

Route::get('/kategori', 'CategoriesController@index')
    ->name('categories.index');

Route::get('/kategori/buat', 'CategoriesController@create')
    ->name('categories.create');

Route::post('/kategori/buat', 'CategoriesController@store')
    ->name('categories.store');

Route::get('/kategori/{category}/edit', 'CategoriesController@edit')
    ->name('categories.edit');

Route::put('/kategori/{category}', 'CategoriesController@update')
    ->name('categories.update');

Route::get('/kategori/{category}', 'CategoriesController@show')
    ->name('categories.show');

Route::delete('/kategori/{category}', 'CategoriesController@destroy')
    ->name('categories.destroy');
