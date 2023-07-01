<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        //Auth
        $token = $request->header("Authorization");
        $JwtAuth = new \JwtAuth();
        $checkToken = $JwtAuth->checkToken($token);

        if ($checkToken) {
            return $next($request);
        }else{
            $data = array(
                'status'    => 'error',
                'code'      => 401,
                'message'   => "User is not authenticated"
            );
        }
        return response()->json($data, $data['code']);
    }
}
