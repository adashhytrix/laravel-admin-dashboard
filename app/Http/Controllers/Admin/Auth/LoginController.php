<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    public function index()
    {
   
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
       
         $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

        $credentials = $request->only('email', 'password');

        if (auth()->guard('admin')->attempt($credentials)) {
             $request->session()->regenerate();
                 $admin = Auth::guard('admin')->user();

        // return match ($admin->role) {
        //     'super_admin' => redirect()->route('admin.dashboard'),
        //     'admin'       => redirect()->route('admin.dashboard'),
        //     'manager'     => redirect()->route('admin.reports'),
        //     'staff'       => redirect()->route('admin.tasks'),
        //     default       => tap(
        //         redirect()->route('admin.login'),
        //         fn () => Auth::guard('admin')->logout()
        //     ),
        // };
            return redirect()->route('admin.dashboard');
        }
 
        return back()
        ->withErrors(['email' => 'Invalid email or password'])
        ->onlyInput('email');
      
    }

    public function logout(Request $request)
{
    Auth::guard('admin')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('admin.login');
}
}
