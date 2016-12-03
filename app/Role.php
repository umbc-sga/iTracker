<?php namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $fillable = ['name', 'display_name', 'description'];

    public function forceDelete()
    {
        $this->users()->sync([]);
        $this->perms()->sync([]);
        return parent::forceDelete();
    }
}