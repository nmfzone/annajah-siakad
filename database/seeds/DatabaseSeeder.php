<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(PreliminaryDataSeeder::class);
         $this->call(ShortLinksSeeder::class);
         $this->call(DummySeeder::class);
    }
}
