<?php

Route::get('/tahun-akademik', 'AcademicYearsController@index')
    ->name('academic_years.index');

Route::get('/tahun-akademik/buat', 'AcademicYearsController@create')
    ->name('academic_years.create');

Route::post('/tahun-akademik/buat', 'AcademicYearsController@store')
    ->name('academic_years.store');

Route::get('/tahun-akademik/{academicYear}/edit', 'AcademicYearsController@edit')
    ->name('academic_years.edit');

Route::get('/tahun-akademik/{academicYear}', 'AcademicYearsController@show')
    ->name('academic_years.show');

Route::delete('/tahun-akademik/{academicYear}', 'AcademicYearsController@destroy')
    ->name('academic_years.destroy');
