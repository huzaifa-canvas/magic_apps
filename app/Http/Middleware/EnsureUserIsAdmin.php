<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Allow only users whose user_role is "admin" into the web admin panel.
     * (The mobile app uses the sanctum API and is unaffected by this.)
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ($user->user_role ?? null) !== 'admin') {
            abort(403, 'You do not have permission to access the admin panel.');
        }

        return $next($request);
    }
}
