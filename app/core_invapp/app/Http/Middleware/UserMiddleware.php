<?php

namespace App\Http\Middleware;

use App\Enums\UserRoles;
use App\Enums\UserStatus;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserMiddleware
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
        if (!Auth::check()) {
            return redirect()->route('auth.login.form');
        }

        $user = Auth::user();
        $role = strtolower(trim((string) $user->role));
        $status = strtolower(trim((string) $user->status));

        if ($role !== UserRoles::USER) {
            Log::error('user.middleware_role_mismatch', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'status' => $user->status,
                'path' => $request->path(),
            ]);

            // If an admin hits user routes, send to admin dashboard instead of force logout loop.
            if (in_array($role, [UserRoles::ADMIN, UserRoles::SUPER_ADMIN], true)) {
                return redirect()->route('admin.dashboard');
            }

            Auth::logout();
            return redirect()->route('auth.login.form');
        }

        if (mandatory_verify() && $status !== UserStatus::ACTIVE) {
            Log::error('user.middleware_status_not_active', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'status' => $user->status,
                'path' => $request->path(),
            ]);

            session()->put('verification_required', $user);
            return redirect()->route('auth.email.verification');
        }

        return $next($request);
    }
}
