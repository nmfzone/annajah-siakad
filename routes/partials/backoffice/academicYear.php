<?php

use App\Http\Controllers\BackOffice\AcademicYearsController;

Route::get('/tahun-akademik', [AcademicYearsController::class, 'index'])
    ->name('academic_years.index');

Route::get('/tahun-akademik/buat', [AcademicYearsController::class, 'create'])
    ->name('academic_years.create');

Route::post('/tahun-akademik/buat', [AcademicYearsController::class, 'store'])
    ->name('academic_years.store');

Route::get('/tahun-akademik/{academicYear}/edit', [AcademicYearsController::class, 'edit'])
    ->name('academic_years.edit');

Route::get('/tahun-akademik/{academicYear}', [AcademicYearsController::class, 'show'])
    ->name('academic_years.show');

Route::delete('/tahun-akademik/{academicYear}', [AcademicYearsController::class, 'destroy'])
    ->name('academic_years.destroy');
