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
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $user = Auth::user();

        if ($user->role === 'company') {
            $hasProfile = \App\Models\Company::where('shalu_user_id', $user->id)->exists();

            return $hasProfile
                ? redirect()->route('company.dashboard')
                : redirect()->route('company.profile.create');
        }

        return redirect()->route('home');
    }

    return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
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
        'password' => 'required|string|confirmed|min:6',
        'role' => 'required|in:user,company'
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'role' => $validated['role'],
    ]);

    Auth::login($user);

    return redirect()->route('home');
}

 public function destroy(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('jobs.index'); // ⬅️ arahkan ke halaman lowongan
}


    // app/Http/Controllers/AuthController.php
// app/Http/Controllers/AuthController.php
    protected function redirectToDashboard()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        \Log::info("Redirecting user: " . $user->id . " with role: " . $user->role);

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');

            case 'company':
                $company = \App\Models\Company::where('shalu_user_id', $user->id)->first();

                if ($company) {
                    return redirect()->route('company.dashboard');
                } else {
                    return redirect()->route('company.profile.create'); // arahkan isi data perusahaan dulu
                }

            case 'user':
                return redirect()->route('user.dashboard');

            default:
                Auth::logout();
                return redirect('/login')->withErrors(['role' => 'Role tidak valid']);
        }
    }

}