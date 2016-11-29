<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

class PurgeCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'basecamp:purgeCache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge all cached basecamp api calls';

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
     * @return mixed
     */
    public function handle()
    {
        if(env('CACHE_DRIVER') != 'database'){
            return $this->error('Cache driver is not set to Database, no action was taken!');
        }

        if(false && $resp = $this->ask('Are you sure you want to purge cache? This will cause slowdowns until cache is rebuilt. (y/N)', 'n'))
            if(strtolower($resp)[0] == 'n')
                return null;

        $rows = DB::table('cache')->select('key')->where('key', 'like', config('cache.prefix').'api%')->delete();
        $this->info('Purged '.$rows.' items from the cache');
    }
}
