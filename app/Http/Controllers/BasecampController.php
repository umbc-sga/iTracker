<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BasecampController extends Controller
{
    public function projects(){
        return ['projects'];
    }

    public function people(){
        return ['people'];
    }
}
