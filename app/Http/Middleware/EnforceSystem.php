<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class EnforceSystem
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
        // dd(Config::get('tenancy.db.system-connection-name', 'system'));
        Config::set(
            'database.default',
            Config::get('tenancy.db.system-connection-name', 'system')
        );

        return $next($request);
    }
}
