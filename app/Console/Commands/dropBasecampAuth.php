<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class dropBasecampAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'basecamp:dropAuth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop API access token and force revalidation';

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
        if($resp = $this->ask('This will terminate all API access until you reauthorize! Are you sure? (y/N)', 'n'))
            if(strtolower($resp)[0] == 'n')
                return null;

        Cache::forget('BCaccessToken');
        Cache::forget('BCrefreshToken');
        Cache::forget('BCexpiration');
    }
}
