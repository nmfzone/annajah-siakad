<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AssetVersioning extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assets:version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache new unique identifier for assets versioning.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        cache()->forever(config('assets.version_cache_name'), Str::randomPlus('numeric', 10));

        $this->info('Assets Versioning has been renewed.');
    }
}
