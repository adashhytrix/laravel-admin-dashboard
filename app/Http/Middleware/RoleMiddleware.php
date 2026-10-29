<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {

        $admin = Auth::guard('admin')->user();

        // Check login
        if (!$admin) {
            abort(401, 'Please login first.');
        }

        // Load roles from the roles table
        $admin->loadMissing('roles.permissions');

        // Get all role slugs assigned to this admin
        $adminRoles = $admin->roles
            ->pluck('slug')
            ->all();
dd($adminRoles, $roles);
        // Allow access if any assigned role matches
        if (empty(array_intersect($adminRoles, $roles))) {
            abort(403, 'You are not authorized to access this page.');
        }

        return $next($request);
    }
}