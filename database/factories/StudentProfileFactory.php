<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentProfileFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'father_name' => $this->faker->name,
            'mother_name' => $this->faker->name,
        ];
    }
}
