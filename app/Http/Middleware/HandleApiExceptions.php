<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;

class HandleApiExceptions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (!empty($response->exception))
            if ($response->exception instanceof HttpException)
                return response()->json([
                    'message' => $response->exception->getMessage()
                ])->setStatusCode($response->exception->getStatusCode());

        return $response;
    }
}
