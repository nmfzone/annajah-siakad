<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(rand(1, 3), true);
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
    }
}
