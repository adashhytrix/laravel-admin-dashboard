<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RolePermissionController extends Controller
{
  public function index(Request $request)
    {
        $roles = Role::orderBy('name')->get();

        $selectedRole = null;
        $selectedPermissions = [];

        if ($request->filled('role_id')) {
            $selectedRole = Role::with('permissions')
                ->findOrFail($request->integer('role_id'));

            $selectedPermissions = $selectedRole->permissions
                ->pluck('id')
                ->all();
        }

        $permissions = Permission::orderBy('slug')->get();

        return view('admin.permissions.index', compact(
            'roles',
            'permissions',
            'selectedRole',
            'selectedPermissions'
        ));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'role_id' => [
                'required',
                'integer',
                Rule::exists('roles', 'id'),
            ],
            'permissions' => ['sometimes', 'array'],
            'permissions.*' => [
                'integer',
                'distinct',
                Rule::exists('permissions', 'id'),
            ],
        ]);

        $role = Role::findOrFail($validated['role_id']);

        // Keep super_admin permissions protected.
        if ($role->slug === 'super_admin') {
            return back()->with(
                'error',
                'Super Admin permissions cannot be changed here.'
            );
        }

        $role->permissions()->sync(
            $validated['permissions'] ?? []
        );

        return redirect()
            ->route('admin.permissions.index', [
                'role_id' => $role->id,
            ])
            ->with('success', 'Permissions updated successfully.');
    }
}
