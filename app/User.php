<?php

namespace App;

use App\Classes\Basecamp\BasecampAPI;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'google_id',
        'google_etag', 'google_token', 'display_name', 'gender'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'updated_at', 'created_at',
        'google_etag', 'google_token', 'google_id', 'gender',
        'password', 'remember_token'
    ];

    public function profile(){
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function generateProfile(BasecampAPI $api){
        if($this->profile()->first() == null)
            foreach($api->people() as $person)
                if($person->email_address == $this->email)
                    return Profile::create(['user_id' => $this->id, 'api_id' => $person->id]);

        return false;
    }

    public function organizations(){
        return $this->hasMany(OrganizationUser::class);
    }

    public static function fullUser($id){
        return User::where('id', $id)
            ->with(
                'profile',
                'organizations',
                'organizations.organization',
                'organizations.role',
                'organizations.role.permissions'
            )->first();
    }

    public function syncPermissions(BasecampAPI $api){
        if($person = $api->personByEmail($this->email)){
            $teams = $api->personTeams($person)->pluck('id')->toArray();

            //Drop organizations they're not in anymore
            OrganizationUser::where('user_id', $this->id)
                            ->with('organization')
                            ->get()
                            ->each(function($org) use ($teams){
                                if(!in_array($org->organization->api_id, $teams))
                                    $org->delete();
                            });


            $orgs = Organization::sync(null, $api)['organizations'];

            $normie = OrganizationRoles::where('title', 'LIKE', '%general%')->first();

            //Add to organizations they're in
            if($normie)
                foreach($orgs as $org) {
                    if (in_array($org->api_id, $teams)) {
                        OrganizationUser::firstOrCreate([
                            'user_id' => $this->id,
                            'organization_id' => $org->id,
                            'organization_role' => $normie->id,
                            'title' => $normie->title
                        ]);
                    }
                }

            return true;
        }

        return null;
    }

    public function hasPermission($organization, $permission){
        if($this->email == env('APP_SUPER_ADMIN', 'nu'))
            return true;

        $organization = OrganizationUser::where('user_id', $this->id)
                                        ->where('organization_id', $organization->id)
                                        ->with('role', 'role.permissions')
                                        ->first();

        if(!is_null($organization))
            foreach($organization->role->permissions as $perm)
                if($permission == $perm)
                    return true;

        return false;
    }
}