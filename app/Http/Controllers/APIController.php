<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function NoAPIResponse(Request $request){
        return response()->json([
            'message' => 'Api call is invalid'
        ])->setStatusCode(400)
            ->header('Content-Type', 'text/json');
    }

    public function currentUser(Request $request){
        $user = User::fullUser(auth()->id());
        if($user->email == env('APP_SUPER_ADMIN'))
            $user->superadmin = true;
        return response()->json($user);
    }
}
