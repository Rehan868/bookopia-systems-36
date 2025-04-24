
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        // This would handle the actual login logic with Laravel's authentication
        // For now, just redirect to dashboard to simulate successful login
        return redirect()->route('dashboard');
    }
    
    public function showSignup()
    {
        return view('auth.signup');
    }
    
    public function signup(Request $request)
    {
        // This would handle the user registration logic
        // For now, just redirect to login page
        return redirect()->route('login')->with('success', 'Account created successfully');
    }
    
    public function logout(Request $request)
    {
        // This would handle the logout logic
        // Auth::logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
    
    public function showOwnerLogin()
    {
        return view('auth.owner-login');
    }
    
    public function ownerLogin(Request $request)
    {
        // This would handle the owner login logic
        // For now, just redirect to owner dashboard
        return redirect()->route('owner.dashboard');
    }
}
