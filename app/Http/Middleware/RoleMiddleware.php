<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @param $role
	 *
	 * @return mixed
	 */
    public function handle($request, Closure $next, $role_id)
    {
        if ( auth()->user()->hasRole($role_id) ) {
            return $next($request);
        }
    	
        return redirect('');
    }
}
