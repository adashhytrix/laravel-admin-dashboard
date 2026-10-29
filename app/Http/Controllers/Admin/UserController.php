<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
class UserController extends Controller
{
    public function index()
    {
        $users = Auth::guard('admin')->user()->load('roles.permissions')->latest()
            ->paginate(10);;
        
        return view('admin.users.index',compact('users'));
    }
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create',compact('roles'));
    }
    public function show($user)
    {
        return view('admin.users.show', compact('user'));
    }
    // public function profile()
    // {
    //     return view('admin.users.prfile');
    // }
    
}
