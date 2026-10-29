<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserProfile;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    public function users(Request $request)
{
    $user = User::where('email', 'manager@example.com')->first();

   
    // dd($user->roles()
    // ->with('permissions')
    // ->get()
    // ->pluck('permissions')
    // ->flatten()
    // ->pluck('slug')
    // ->unique()
    // ->values());
    // Verify admin access
    if (!$request->user()->is_admin) {
        return response()->json([
            'success' => false,
            'message' => 'Admin access required.',
        ], 403);
    }

    // Search by name or email
    $query = User::query()
        ->select('id', 'name', 'email', 'is_admin', 'created_at');

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Paginated user listing
    $users = $query->latest()->paginate(
        min(max((int) $request->input('per_page', 10), 1), 100)
    );

    return response()->json([
        'success' => true,
        'message' => 'Users fetched successfully.',
        'data' => $users->items(),
        'pagination' => [
            'current_page' => $users->currentPage(),
            'per_page' => $users->perPage(),
            'total' => $users->total(),
            'last_page' => $users->lastPage(),
        ],
    ], 200);
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          $users = UserProfile::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
         $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['sometimes', 'string', 'min:8'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $user = User::create($data);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        // dd($request->all());
        if (!$request->user()->is_admin) {
        return response()->json([
            'success' => false,
            'message' => 'Admin access required.',
        ], 403);
    }

    $user = User::find($id);

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User not found.',
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => 'User details fetched successfully.',
        'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_admin' => (bool) $user->is_admin,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ],
    ], 200);
    }
   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserProfile $user)
    {
         $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => [
                'sometimes', 'required', 'email',
                Rule::unique('user_profiles', 'email')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $user->update($data);

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user->fresh(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
          if (!$request->user()->is_admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Admin access required.',
                ], 403);
            }

            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                ], 404);
            }

            // Prevent deleting the currently logged-in account
            if ($user->id === $request->user()->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot delete your own account.',
                ], 403);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully.',
            ], 200);
    }
}