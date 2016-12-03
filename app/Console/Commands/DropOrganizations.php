<?php

namespace App\Console\Commands;

use App\Organization;
use App\OrganizationRoles;
use App\OrganizationUser;
use App\RolePermission;
use Illuminate\Console\Command;

class DropOrganizations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'basecamp:dropOrgs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop all organizational data from the database';

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
        if($resp = $this->ask('This will destroy all organizational data! Are you sure? (y/N)', 'n'))
            if(strtolower($resp)[0] == 'n')
                return null;

        $records = Organization::where('id', '!=', 'null')->delete()
                    + OrganizationUser::where('id', '!=', 'null')->delete()
                    + OrganizationRoles::where('id', '!=', 'null')->delete()
                    + RolePermission::where('id', '!=', 'null')->delete();

        $this->info($records.' records deleted');
    }
}
