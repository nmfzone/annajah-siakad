<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Cache::clear();
        $this->call(ShortLinksSeeder::class);
        $this->call(DummySeeder::class);
        $this->call(ArticlesSeeder::class);
        $this->call(AcademicYearsSeeder::class);
    }
}
