<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = ['api_id', 'name'];

    protected $guarded = ['id'];

    public function people(){
        return $this->hasManyThrough(User::class, OrganizationUser::class,
            'user_id', 'organization_id', 'id');
    }

    /**
     * @param $teams Collection
     * @return array
     */
    public static function sync($teams){
        $orgs = Organization::all();

        $validOrgs = $teams->pluck('id');
        $currentOrgs = $orgs->pluck('api_id');

        $needToCreate = $validOrgs->diff($currentOrgs);
        $needToDelete = $currentOrgs->diff($validOrgs);

        //@todo Cascade on DB
        $deleted = Organization::whereIn('api_id', $needToDelete)->delete();

        $teams->filter(function($org) use ($needToCreate){
            return $needToCreate->search($org->id) !== false;
        })->each(function($org) use (&$orgs){
            $orgs->push(Organization::create([
                'api_id' => $org->id,
                'name' => $org->name
            ]));
        });

        return [
            'organizations' => $orgs->filter(function($org) use ($validOrgs){
                return $validOrgs->search($org->api_id) !== false;
            }),
            'deleted' => $deleted
        ];
    }
}
