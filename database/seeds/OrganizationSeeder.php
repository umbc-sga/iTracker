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
            'normie' => 'Cabinet Officer',
            'peasant' => 'General Member'
        ];

        foreach($titles as $key => $title)
            $titles[$key] = OrganizationRoles::create(['title' => $title]);

        $permissions = collect([
            'addOfficer' => [$titles['exec']],
            'updatePersonalInfo' => $titles,
            'makeAdmin' => [$titles['exec']],
            'createPosition' => $titles,
            'makeExec' => [$titles['exec']],
            'removePosition' => $titles,
            'demotePerson' => [$titles['exec']],
            'updateMEmbersInfo' => [$titles['exec'], $titles['normie']],
            'removeCabinetOfficer' => [$titles['exec']]
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
