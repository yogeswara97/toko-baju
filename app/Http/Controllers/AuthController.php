<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan model User sudah ada

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function loginForm()
    {
        $title = "Login";
        return view('auth.login', compact('title'));
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            session([
                'user' => [
                    'id' => Auth::id(),
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'role' => Auth::user()->role,
                ],
            ]);

            $role = Auth::user()->role;
            return match ($role) {
                'admin' => redirect('/admin'),
                'customer' => redirect('/'),
                default => redirect('/'),
            };
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah. Silakan coba lagi.'])
            ->withInput($request->only('email', 'remember'));
    }



    // Menampilkan halaman registrasi
    public function registrationForm()
    {
        $title = "Register";
        return view('auth.register', compact('title'));
    }

    // Proses registrasi
    public function registration(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer' // default role
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/')->with('success', 'Registrasi berhasil, selamat datang!');
    }

    // Logout
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Kamu udah logout.');
    }
}
