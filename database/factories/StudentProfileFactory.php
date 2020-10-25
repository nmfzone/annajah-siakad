<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Student;
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

$factory->define(Student::class, function (Faker $faker) {
    return [
        'father_name' => $faker->name,
        'mother_name' => $faker->name,
    ];
});
