<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\Models\Site;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->unique()->words(rand(1, 3), true);
    $siteId = Arr::random([
        null,
        optional(Site::inRandomOrder()->first())->id,
    ]);

    return [
        'slug' => Str::slug($name),
        'name' => $name,
        'site_id' => $siteId,
        'parent_id' => function () use ($siteId) {
            return Arr::random([
                null,
                optional(
                    Category::inRandomOrder()
                        ->where('site_id', $siteId)
                        ->first()
                )->id,
            ]);
        },
    ];
});
