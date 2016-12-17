<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AngularController extends Controller
{
    /**
     * Get angular page
     * @param Request $request
     * @param $page string page name
     * @return \Illuminate\Contracts\View\View
     */
    public function view(Request $request, $page)
    {
        $name = 'angular.'.$page;

        if(view()->exists($name))
            return view()->make($name);
        else
            return $this->noview($request);
    }

    /**
     * No angular view found
     * @param Request $request
     * @return mixed
     */
    public function noview(Request $request){
        return response()->json([
            'message' => 'No view found'
        ])->setStatusCode(404)
            ->header('Content-Type', 'text/json');
    }
}
