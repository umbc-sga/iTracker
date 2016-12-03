<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganizationUser extends Model
{
    protected $fillable = ['user_id', 'organization_id', 'organization_role', 'title'];

    protected $hidden = ['id'];

    public function role(){
        return $this->hasOne(OrganizationRoles::class, 'id', 'organization_role');
    }

    public function organization(){
        return $this->hasOne(Organization::class, 'id', 'organization_id');
    }
}
