<?php

namespace App\Console\Commands;

use App\Classes\Basecamp\BasecampAPI;
use App\Organization;
use Illuminate\Console\Command;

use DB;

class SyncOrganizations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'basecamp:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync organizational information from API';

    protected $api = null;

    /**
     * Create a new command instance.
     *
     * @param BasecampAPI $api
     */
    public function __construct(BasecampAPI $api)
    {
        $this->api = $api;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //DB::beginTransaction();

        $orgs = Organization::sync($this->api->teams());

        //DB::rollBack();
        $this->info('Synced, there are '.$orgs['organizations']->count().' organizations');
        $this->info('Deleted '.$orgs['deleted'].' organizations');

        return $orgs;
    }
}
