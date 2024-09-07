<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {

        foreach ($roles as $role) {

            // if (auth()->user()->role->name == $role || auth()->user()->role->name == 'admin') {
            if (Gate::check('manage')) {

                return $next($request);
            }
        }

        abort('403');
    }
}
