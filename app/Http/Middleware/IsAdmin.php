<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
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
        if (auth()->check()){
           if (auth()->user()->isAdmin() == 1){
              $isAdmin = true;
           }
           elseif (auth()->user()->isAdmin() == 2){
              $isAdmin = true;
           }
           else
              return response('Unauthorized.', 401);
           
        }

        return $next($request);
    }
}
