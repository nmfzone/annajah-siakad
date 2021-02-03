<?php

namespace Database\Seeders;

use App\Models\ShortLink;
use Illuminate\Database\Seeder;

class ShortLinksSeeder extends Seeder
{
    public function run()
    {
        ShortLink::factory(10)->create();
    }
}
