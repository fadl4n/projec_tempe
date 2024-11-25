<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function login()
    {
        return view('login');
    }

    // Proses login
    public function loginProses(Request $request)
    {
        // Validasi data login
        $validateData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Regenerate session to prevent fixation
            $request->session()->regenerate();

            // Cek apakah pengguna adalah admin atau bukan
            $user = Auth::user();
            if ($user->isAdmin === 0) {
                // Arahkan pengguna non-admin ke dashboard pengguna
                return redirect()->route('dashboard-dash-user.index'); // Ganti dengan route yang sesuai
            }

            // Arahkan pengguna admin ke dashboard utama
            return redirect()->intended('dashboard'); // Ganti dengan route yang sesuai untuk admin
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function register()
    {
        return view('register');
    }

    // Proses register
    public function registerProses(Request $request)
    {
        // Validasi input dari form register
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15|min:11',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Simpan user baru ke database
        $user = User::create([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Login user setelah registrasi
        Auth::login($user);

        // Redirect ke dashboard pengguna setelah register
        return redirect()->route('dashboard-dash-user.index'); // Ganti dengan route yang sesuai
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
