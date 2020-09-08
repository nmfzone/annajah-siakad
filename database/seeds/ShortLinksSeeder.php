<?php

use App\Models\ShortLink;
use Illuminate\Database\Seeder;

class ShortLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ShortLink::class, 10)->create();
    }
}
