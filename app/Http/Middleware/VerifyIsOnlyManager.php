<?php

namespace App\Http\Middleware;

use Closure;

class VerifyIsOnlyManager
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
        if(!auth()->user()->isManager()){
            return response()->json("You don't have permission to access on this Information");
        }
        return $next($request);
    }
}
