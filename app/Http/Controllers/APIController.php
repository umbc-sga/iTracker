<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{
    public function NoAPIResponse(Request $request){
        return response()->json([
            'message' => 'Api call is invalid'
        ])->setStatusCode(400)
            ->header('Content-Type', 'text/json');
    }
}
