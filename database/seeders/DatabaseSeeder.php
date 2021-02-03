<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $result = Cache::clear();

        if (! $result) {
            throw new Exception('Cannot delete cache files. Please delete manually.');
        }

        $this->call(ShortLinksSeeder::class);
        $this->call(DummySeeder::class);
        $this->call(ArticlesSeeder::class);
        $this->call(AcademicYearsSeeder::class);
    }
}
