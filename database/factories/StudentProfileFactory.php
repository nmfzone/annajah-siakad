<?php

namespace Database\Factories;

use App\Models\Site;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentProfileFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        $site = Site::inRandomOrder()->firstOrFail();
        $decision = $this->faker->boolean(70);

        $acceptedAt = $decision
            ? now()->subYears($this->faker->randomElement(range(4, 10)))
            : null;

        return [
            'nis' => Student::generateNis($site),
            'father_name' => $this->faker->name,
            'mother_name' => $this->faker->name,
            'wali_name' => $this->faker->name,
            'accepted_at' => $acceptedAt,
            'graduated_at' => $decision ? $acceptedAt->addYear() : null,
        ];
    }
}
