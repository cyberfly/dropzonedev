<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        //get current logged in user info
        $user = auth()->user();

        //check user role, break if role not allowed

        if (!$user->hasRole($role)) {
            dd('Anda bukan admin, tak boleh akses kawasan ini');
        }

        return $next($request);
    }
}
