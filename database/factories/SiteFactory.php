<?php

namespace Database\Factories;

use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteFactory extends Factory
{
    protected $model = Site::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->randomElement(['SDIT', 'SMPIT']) . ' Muhammadiyah An Najah',
            'domain' => $this->faker->randomElement(['sdit', 'smpit']) . '.' . config('app.host'),
            'address' => $this->faker->address,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'instagram' => 'ig_' . $this->faker->userName,
            'facebook' => 'fb_' . $this->faker->userName,
            'twitter' => 'tw_' . $this->faker->userName,
        ];
    }
}
