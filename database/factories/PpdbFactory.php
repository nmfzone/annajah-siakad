<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use App\Models\Ppdb;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PpdbFactory extends Factory
{
    protected $model = Ppdb::class;

    public function definition(): array
    {
        $academicYear = AcademicYear::whereDoesntHave('ppdb')
            ->inRandomOrder()
            ->firstOrFail();

        $startedAt = Carbon::create($academicYear->from - 1, 11, 10);
        $endedAt = Carbon::create($academicYear->from, 2, 10);

        return [
            'started_at' => $startedAt,
            'ended_at' => $endedAt,
            'academic_year_id' => $academicYear->id,
        ];
    }
}
