<?php

use Illuminate\Database\Seeder;

use App\OrganizationRoles;
use App\RolePermission;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws Exception
     */
    public function run()
    {
        if(OrganizationRoles::where('id', '!=', 'null')->count() > 0)
            throw new Exception('Cannot create roles and permissions when tables are populated.');

        $titles = [
            'exec' => 'Executive Officer',
            'cabinet' => 'Cabinet Officer',
            'peasant' => 'General Member'
        ];

        foreach($titles as $key => $title)
            $titles[$key] = OrganizationRoles::create(['title' => $title, 'stub' => $key]);

        $permissions = collect([
            'makeAdmin' => [$titles['exec']],
            'makeExec' => [$titles['exec']],
            'editOfficers' => [$titles['exec']],
            'updateMembersInfo' => [$titles['exec'], $titles['cabinet']],
        ]);

        $permissions->transform(function($organizations, $permission){
            $permissions = [];

            foreach($organizations as $org)
                $permissions[] = RolePermission::create([
                    'permission' => $permission,
                    'organization_role_id' => $org->id
                ]);

            return $permissions;
        });
    }
}
