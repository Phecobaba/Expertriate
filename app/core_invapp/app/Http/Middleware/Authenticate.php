<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     * @version 1.0.0
     * @since 1.0
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            Log::error('auth.middleware_unauthenticated_redirect', [
                'path' => $request->path(),
                'full_url' => $request->fullUrl(),
                'has_session_cookie' => $request->hasCookie(config('session.cookie')),
                'session_cookie_name' => config('session.cookie'),
                'session_id' => optional($request->session())->getId(),
                'app_url' => config('app.url'),
                'session_driver' => config('session.driver'),
                'session_path' => config('session.path'),
                'session_domain' => config('session.domain'),
                'session_secure' => config('session.secure'),
            ]);
            return route('auth.login.form');
        }
    }
}
