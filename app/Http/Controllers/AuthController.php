<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function formLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Coba login dengan Auth
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Regenerasi session demi keamanan

            $role = auth()->user()->role;

            // Arahkan sesuai peran
            if ($role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($role === 'company') {
                return redirect('/company/dashboard');
            } else {
                return redirect('/user/dashboard');
            }
        }

        // Kalau gagal login
        return back()->with('error', 'Email atau password salah');
    }

    // Menampilkan halaman register
    public function formRegister()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        // Validasi input register
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role' => 'required|in:admin,company,user',
        ]);

        // Simpan user baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login');
    }

    // Logout
    public function destroy(Request $request)
    {
        Auth::logout();

        // Invalidate session & regenerate token untuk keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
