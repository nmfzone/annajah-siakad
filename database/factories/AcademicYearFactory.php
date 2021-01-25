<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Garages\Utility\Unique;
use App\Models\AcademicYear;
use App\Models\Site;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(AcademicYear::class, function (Faker $faker) {
    $from = Unique::generate(AcademicYear::class, function () use ($faker) {
        return $faker->randomElement(range(2000, 2040));
    }, 'from');

    return [
        'name' => $from . '/' . ($from+1),
        'from' => $from,
        'to' => $from+1,
        'site_id' => Site::inRandomOrder()->first()->id,
    ];
});
