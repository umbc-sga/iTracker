<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['api_id', 'biography', 'major',
        'classStanding', 'hometown', 'user_id', 'fact'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['user_id', 'id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}