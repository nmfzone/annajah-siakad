<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Seeder;

class AcademicYearsSeeder extends Seeder
{
    public function run()
    {
        foreach (range(1, 30) as $item) {
            AcademicYear::factory()->create();
        }
    }
}
