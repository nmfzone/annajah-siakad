<?php

namespace Database\Factories;

use App\Garages\Utility\Unique;
use App\Models\AcademicYear;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

class AcademicYearFactory extends Factory
{
    protected $model = AcademicYear::class;

    public function definition(): array
    {
        $from = Unique::generate(AcademicYear::class, function () {
            return $this->faker->randomElement(range(2000, 2040));
        }, 'from');

        return [
            'name' => $from . '/' . ($from + 1),
            'from' => $from,
            'to' => $from + 1,
            'site_id' => Site::inRandomOrder()->first()->id,
        ];
    }
}
