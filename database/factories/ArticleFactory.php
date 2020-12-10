<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\ArticleType;
use App\Models\Article;
use App\Models\User;
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

$factory->define(Article::class, function (Faker $faker) {
    return [
        'slug' => $faker->unique()->slug,
        'type' => ArticleType::ARTICLE,
        'title' => $faker->sentence,
        'content' => $faker->paragraphs(6, true),
        'user_id' => function () {
            return User::inRandomOrder()->first()->id;
        }
    ];
});
