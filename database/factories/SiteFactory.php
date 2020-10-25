<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

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

$factory->define(Site::class, function (Faker $faker) {
    return [
        'title' => $faker->randomElement(['SDIT', 'SMPIT']) . ' Muhammadiyah An Najah',
        'domain' => $faker->randomElement(['sdit', 'smpit']) . '.' . config('app.host')
    ];
});
