<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = $request->user();

        if (! $user || $user->role !== $role) {
            return response()->json(['message' => 'Forbidden: Access denied.'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
