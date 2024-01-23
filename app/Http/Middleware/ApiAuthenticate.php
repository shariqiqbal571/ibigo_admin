<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->user()){
            return response()->json([
                'message'=>"No User Found!",
                'status'=>false,
                'code'=>404
            ]);
        }
        else{
            if(!$request->user()->email_verified_at){
                return response()->json([
                    'message'=>"Your are not verified!",
                    'status'=>false,
                    'code'=>401
                ]);
            }
            else
            {
                return response()->json([
                    'message'=>"Your are successfully SignIn!",
                    'status'=>true,
                    'code'=>200
                ]);
            }
        }
        return $next($request);
    }
}
