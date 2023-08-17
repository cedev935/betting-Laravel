<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DemoMode
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
        $methods = ['POST','PUT','PATCH','DELETE'];
        if(in_array(request()->method(), $methods)){
            return back()->with('error', 'Demo Version not allowed to changing');
        }
        return $next($request);
    }
}
