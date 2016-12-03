<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganizationRoles extends Model
{
    protected $fillable = ['title'];

    public function permissions(){
        $this->hasMany(RolePermission::class, 'organization_role_id', 'id');
    }
}
