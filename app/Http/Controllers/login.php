<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class login extends Controller
{
    // Tampilkan halaman login
    public function index()
    {
        // Jika sudah login, redirect sesuai role
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('login');
    }

    // Proses login
    public function proses(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            return $this->redirectByRole($role);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Berhasil logout.');
    }

    // Helper redirect berdasarkan role
    private function redirectByRole($role)
    {
        switch ($role) {
            case 'admin_pusat':
                return redirect()->route('dashboard.adminPusat');
            case 'kepala_cabang':
                return redirect()->route('dashboard.kepalaCabang');
            case 'kasir':
                return redirect()->route('dashboard.kasir');
            case 'manager':
                return redirect()->route('dashboard.manager');    
            default:
                Auth::logout();
                return redirect('/login')->withErrors(['email' => 'Role tidak dikenali.']);
        }
    }
}