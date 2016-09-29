<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AngularController extends Controller
{
    public function view($page)
    {
        $name = 'angular.'.$page;

        if(view()->exists($name))
            return view()->make($name);
        else
            return response(json_encode([
                'error' => 'No view "'.$page.'"" found',
                'status' => 404
            ]), 404);
    }
}
