<?php

namespace Database\Factories;

use App\Enums\ArticleType;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'slug' => $this->faker->unique()->slug,
            'type' => ArticleType::ARTICLE,
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(6, true),
            'user_id' => function () {
                return User::inRandomOrder()->first()->id;
            }
        ];
    }
}
