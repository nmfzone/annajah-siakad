<?php

namespace Database\Factories;

use App\Enums\SelectionMethod;
use App\Models\Ppdb;
use App\Models\PpdbUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PpdbUserFactory extends Factory
{
    protected $model = PpdbUser::class;

    public function definition(): array
    {
        return [
            'ppdb_id' => function () {
                return Ppdb::inRandomOrder()->first()->id;
            },
            'user_id' => function () {
                return User::students()->inRandomOrder()->first()->id;
            },
            'selection_method' => $this->faker->randomElement(SelectionMethod::asArray()),
        ];
    }
}
