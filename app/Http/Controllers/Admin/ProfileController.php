<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Role;
class ProfileController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user()->load('roles.permissions');
// $admin = Auth::guard('admin')->user();


        return view('admin.profile.index', compact('admin'));
    }

     public function update(Request $request)
{
    $admin = Auth::guard('admin')->user();

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'bio' => ['nullable', 'string', 'max:1000'],
        'profile_image' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
    ]);

    // Upload profile image only if a new image is selected
    if ($request->hasFile('profile_image')) {

        // Delete old image
        if ($admin->profile_image) {
            Storage::disk('public')->delete(
                $admin->profile_image
            );
        }

        // Store new image
        $validated['profile_image'] = $request
            ->file('profile_image')
            ->store('profiles', 'public');
    }

    // Update name, bio, and image (if provided)
    $admin->update($validated);

    return redirect()
        ->route('admin.profile.index')
        ->with('success', 'Profile updated successfully.');
}
}