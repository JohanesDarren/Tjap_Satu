<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthFlowController extends Controller
{
    // GET /register
    public function showRegister()
    {
        return view('Auth.register');
    }

    // POST /login (tanpa validasi/auth, hanya redirect)
    public function submitLogin(Request $request)
    {
        // Contoh ambil email (opsional, hanya untuk flash di UI)
        $email = $request->input('email');

        // Redirect ke home + flash message (opsional)
        return redirect()
            ->route('home')
            ->with('status', 'Selamat datang kembali' . ($email ? ', ' . $email : '') . '!');
    }

    // POST /register (tanpa simpan data, hanya redirect)
    public function submitRegister(Request $request)
    {
        $name = $request->input('name');

        return redirect()
            ->route('home')
            ->with('status', 'Pendaftaran berhasil' . ($name ? ', ' . $name : '') . '! Kamu sudah bisa mulai order.');
    }
}