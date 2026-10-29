<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use Illuminate\Validation\Rule;


class AdminAuthController extends Controller
{
    // POST /api/login
    public function login(Request $request)
    {
      
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (
            !$user ||
            !Hash::check($request->password, $user->password)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        if (!$user->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin access required',
            ], 403);
        }

        $token = $user->createToken('admin-api')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Admin login successful',
            'data' => [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer',
            ],
        ], 200);
    }

    // POST /api/logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful',
        ], 200);
    }

    // GET /api/admin/dashboard
    public function dashboard(Request $request)
    {
        
        $admin = $request->user();

        return response()->json([
            'success' => true,
            'message' => 'Dashboard statistics fetched successfully',
            'data' => [
                'admin' => [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'email' => $admin->email,
                ],
                'statistics' => [
                    'total_users' => User::count(),
                    'total_admins' => User::where('is_admin', true)->count(),
                    'total_customers' => User::where('is_admin', false)->count(),
                ],
            ],
        ], 200);
    }

    public function assignRole(Request $request, int $id)
{
    $request->validate([
        'role_id' => [
            'required',
            'integer',
            Rule::exists('roles', 'id'),
        ],
    ]);

    $user = User::findOrFail($id);
    $role = Role::findOrFail($request->role_id);

    $user->roles()->syncWithoutDetaching([$role->id]);

    return response()->json([
        'success' => true,
        'message' => 'Role assigned successfully.',
        'user' => $user->load('roles'),
    ]);
}
}