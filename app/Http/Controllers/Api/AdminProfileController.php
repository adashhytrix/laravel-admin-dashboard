<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
    // GET /api/admin/profile
    public function profile(Request $request)
    {
        $admin = $request->user();

        if (!$admin->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin access required.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile fetched successfully.',
            'data' => [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'created_at' => $admin->created_at,
            ],
        ], 200);
    }

    // PUT /api/admin/profile
   public function updateProfile(Request $request)
{
    $admin = $request->user();

    if (!$admin) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthenticated. Please login first.',
        ], 401);
    }

    if (!$admin->is_admin) {
        return response()->json([
            'success' => false,
            'message' => 'Admin access required.',
        ], 403);
    }

    $validator = Validator::make($request->all(), [
        'name' => ['sometimes', 'required', 'string', 'max:255'],
        'email' => [
            'sometimes',
            'required',
            'email',
            'max:255',
            Rule::unique('users', 'email')->ignore($admin->id),
        ],
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $validator->errors(),
        ], 422);
    }

    $admin->fill($validator->validated());
    $admin->save();

    return response()->json([
        'success' => true,
        'message' => 'Profile updated successfully.',
        'data' => [
            'id' => $admin->id,
            'name' => $admin->name,
            'email' => $admin->email,
            'updated_at' => $admin->updated_at,
        ],
    ], 200);
    }

    // PUT /api/admin/change-password
    public function changePassword(Request $request)
    {
        $admin = $request->user();

        if (!$admin->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin access required.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'different:current_password',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        if (!Hash::check(
            $request->current_password,
            $admin->password
        )) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.',
            ], 422);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        // Revoke existing tokens after password change.
        $admin->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully. Please login again.',
        ], 200);
    }
}