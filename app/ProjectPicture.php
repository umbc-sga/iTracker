<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectPicture extends Model
{
    protected $fillable = ['src', 'api_id'];

    protected $hidden = ['id', 'updated_at', 'created_at', 'api_id'];
}
