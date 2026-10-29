<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$permissions
    ): Response {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            abort(403, 'Unauthorized access.');
        }

        $admin->loadMissing('roles.permissions');

        // Super Admin ko sabhi pages ka access
        if ($admin->roles->contains('slug', 'super_admin')) {
            return $next($request);
        }

        $assignedPermissions = $admin->roles
            ->flatMap(fn ($role) => $role->permissions)
            ->pluck('slug')
            ->unique();

        foreach ($permissions as $permission) {
            if ($assignedPermissions->contains($permission)) {
                return $next($request);
            }
        }

        abort(403, 'You do not have permission to access this page.');
    }
}