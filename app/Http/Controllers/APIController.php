<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class APIController extends Controller
{
    /**
     * No API found
     * @param Request $request
     * @return mixed
     */
    public function NoAPIResponse(Request $request){
        return response()->json([
            'message' => 'Api call is invalid'
        ])->setStatusCode(400)
            ->header('Content-Type', 'text/json');
    }

    /**
     * Get current authenticated user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentUser(Request $request){
        $user = User::fullUser(auth()->id());
        if($user->email == env('APP_SUPER_ADMIN'))
            $user->superadmin = true;
        return response()->json($user);
    }
}
