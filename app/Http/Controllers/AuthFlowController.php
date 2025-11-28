<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Customer;

class AuthFlowController extends Controller
{
    // GET /register -> redirect ke section register di landing
    public function showRegister()
    {
        return redirect()->to(route('home') . '#register');
    }

    // POST /login (auth customer)
    public function submitLogin(Request $request)
    {
        $request->merge(['email' => strtolower(trim((string) $request->input('email')))]);
        $credentials = $request->validate([
            'email' => ['required','string','email:rfc','max:254'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        if (Auth::guard('customer')->attempt($credentials, false)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('status', 'Berhasil masuk. Selamat datang kembali!');
        }

        return back()->withErrors(['email' => 'Email atau kata sandi salah.'])->with('show_login', true)->onlyInput('email');
    }

    // POST /register (buat customer + login)
    public function submitRegister(Request $request)
    {
        $request->merge(['email' => strtolower(trim((string) $request->input('email')))]);
        $validated = $request->validate([
            'nama_lengkap' => ['required','string','min:3'],
            'alamat' => ['required','string','max:255'],
            'email' => ['required','string','email:rfc,dns','max:254', Rule::unique('customer','email')],
            'no_telp' => ['required','string','max:30', Rule::unique('customer','no_telp')],
            'password' => ['required','string','min:8'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_telp.unique' => 'Nomor telepon sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        // Simpan (password otomatis di-hash via casts)
        $customer = Customer::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'alamat' => $validated['alamat'],
            'email' => $validated['email'],
            'no_telp' => $validated['no_telp'],
            'password' => $validated['password'],
        ]);

        // Login otomatis
        Auth::guard('customer')->login($customer);
        $request->session()->regenerate();

        return redirect()->route('home')->with('status', 'Pendaftaran berhasil. Selamat datang, ' . $customer->nama_lengkap . '!');
    }
}
