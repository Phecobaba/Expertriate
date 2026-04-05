<?php

namespace App\Http\Middleware;

use App\Enums\UserRoles;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     * @version 1.0.0
     * @since 1.0
     */
    public function handle($request, Closure $next)
    {
        $adminRoles = [ UserRoles::SUPER_ADMIN, UserRoles::ADMIN ];

        if (!in_array(Auth::user()->role, $adminRoles)) {
            Auth::logout();
            return redirect()->route('auth.login.form');
        }

        return $next($request);
    }
}
