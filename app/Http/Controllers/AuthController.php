<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required'
        ]);

        // 2. Coba Login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            $user = Auth::user();

            // 3. Cek apakah role di DB sama dengan role yang dipilih di login
            if ($user->role !== $request->role) {
                Auth::logout();
                
                // Tambahkan 2 baris ini agar session benar-benar bersih dan aman
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->with('loginError', 'Role yang Anda pilih tidak sesuai dengan akun ini.');
            }


            // 4. Pengalihan (Redirect) berdasarkan Role
            if ($user->role == 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/wali/dashboard');
            }
        }

        // Jika gagal
        return back()->with('loginError', 'Email atau Password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}