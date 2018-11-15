<?php

namespace App\Http\Middleware;

use Closure;

class Permission
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

        $roles = array_except(func_get_args(), [0,1]);


        if (in_array($request->header('role'), $roles) ) {

            return $next($request);

        }else{

            return response()->json(['result'=> 'vous n\'avez pas les droits d\'acces '],403);
        }


    }
}
