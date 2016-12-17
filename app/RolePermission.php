<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $fillable = ['permission'];

    protected $hidden = ['created_at', 'updated_at', 'organization_role_id', 'id'];
}
