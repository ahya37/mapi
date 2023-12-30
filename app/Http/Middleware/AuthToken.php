<?php

namespace App\Http\Middleware;

use Closure;

class AuthToken
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
        #get token via headers
        $token = $request->header('Authorization');
        if (empty($token)) {
           return response()->json([
                'message' => 'Authorization Header is empty'
           ]);
        }
        
        return $next($request);
    }
}
