<?php

use App\Models\Article;
use App\Models\Site;
use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    public function run()
    {
        factory(Article::class, 50)->create();

        Site::all()->each(function (Site $site) {
            factory(Article::class, 50)
                ->create([
                    'site_id' => $site->id,
                ]);
        });
    }
}
