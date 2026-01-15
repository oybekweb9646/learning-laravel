<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, string $role)
    {
        if (auth('api')->user()?->role !== $role) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
