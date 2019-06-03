<?php

namespace App\Http\Middleware;

use Closure;

class VerifyIsAdmin
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
        if(!auth()->user()->isAdmin()){
            return response()->json("You don't have permission to access on this Route");
        }
        return $next($request);
    }
}
