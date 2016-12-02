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
    protected $hidden = ['password', 'remember_token'];

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
}