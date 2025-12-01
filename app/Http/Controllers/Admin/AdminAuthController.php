<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // Tampilkan halaman login admin
    public function showLogin()
    {
        if (\Illuminate\Support\Facades\Auth::guard('customer')->check() && \Illuminate\Support\Facades\Auth::guard('customer')->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        // Tampilkan modal login di landing page
        return redirect()->route('home', ['login' => 1])
            ->with('show_login', true)
            ->with('admin_login', true);
    }

    // Proses login admin
    public function login(Request $request)
    {
        $request->merge(['email' => strtolower(trim((string) $request->input('email')))]);
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Validasi if exist: customer admin harus ada
        $adminExists = \App\Models\Customer::where('email', $credentials['email'])
            ->where('is_admin', true)
            ->exists();
        if (!$adminExists) {
            return redirect()->route('home', ['login' => 1])
                ->with('show_login', true)
                ->with('admin_login', true)
                ->withErrors(['email' => 'Akun admin tidak ditemukan atau tidak memiliki akses admin.'])
                ->withInput($request->only('email'));
        }

        if (\Illuminate\Support\Facades\Auth::guard('customer')->attempt($credentials, false)) {
            // pastikan role admin
            if (\Illuminate\Support\Facades\Auth::guard('customer')->user()->is_admin) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Selamat datang, ' . \Illuminate\Support\Facades\Auth::guard('customer')->user()->name . '!');
            }
            \Illuminate\Support\Facades\Auth::guard('customer')->logout();
            return redirect()->route('home', ['login' => 1])
                ->with('show_login', true)
                ->with('admin_login', true)
                ->withErrors(['email' => 'Akun ini tidak memiliki akses admin.'])
                ->withInput($request->only('email'));
        }

        return redirect()->route('home', ['login' => 1])
            ->with('show_login', true)
            ->with('admin_login', true)
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput($request->only('email'));
    }

    // Logout admin
    public function logout(Request $request)
    {
        \Illuminate\Support\Facades\Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // Bersihkan flag modal
        $request->session()->forget(['show_login','admin_login']);

        return redirect('/');
    }
}
