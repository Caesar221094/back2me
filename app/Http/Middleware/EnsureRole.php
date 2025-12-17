<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware("role:superadmin|petugas")
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        $allowed = explode('|', $roles);

        if (! in_array($user->role, $allowed)) {
            abort(403);
        }

        if ($user->is_banned) {
            abort(403, 'Akun diblokir');
        }

        return $next($request);
    }
}
