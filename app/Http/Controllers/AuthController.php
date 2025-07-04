<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function formLogin()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return $this->redirectToDashboard()
                ->with('success', 'Login berhasil!');
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'Email atau password salah']);
    }

    public function formRegister()
{
    return view('auth.register'); // Pastikan view ini ada
}

public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|confirmed'
    ]);
    
    User::create($validated);
    
    return redirect()->route('login')
         ->with('success', 'Registrasi berhasil! Silakan login');
}
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')
            ->with('success', 'Anda telah logout.');
    }

   // app/Http/Controllers/AuthController.php
// app/Http/Controllers/AuthController.php
protected function redirectToDashboard()
{
    $user = Auth::user();
    
    if (!$user) {
        return redirect('/login');
    }

    // Debugging
    \Log::info("Redirecting user: ".$user->id." with role: ".$user->role);

    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'company':
            return redirect()->route('company.dashboard');
        case 'user':
            return redirect()->route('user.dashboard');
        default:
            Auth::logout();
            return redirect('/login')->withErrors(['role' => 'Role tidak valid']);
    }
}
}