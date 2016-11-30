<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AngularController extends Controller
{
    public function view(Request $request, $page)
    {
        $name = 'angular.'.$page;

        if(view()->exists($name))
            return view()->make($name);
        else
            return $this->noview($request);
    }

    public function noview(Request $request){
        return response()->json([
            'message' => 'No view found'
        ])->setStatusCode(404)
            ->header('Content-Type', 'text/json');
    }
}
