<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    private static $users = [
        ['name' => 'Admin Kopi', 'email' => 'admin@tjap1.com', 'password' => '123456'],
        ['name' => 'User Biasa', 'email' => 'user@tjap1.com', 'password' => 'password']
    ];

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        $user = collect(self::$users)->firstWhere('email', $request->email);
        if ($user && $user['password'] === $request->password) {
            session(['user' => $user]);
            return redirect()->route('order.index');
        }

        return back()->with('showLogin', true)
                     ->withErrors(['email' => 'Email atau password salah.'], 'login');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect()->route('home');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $newUser = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        session(['user' => $newUser]);
        return redirect()->route('order.index');
    }

    public function order(Request $request)
    {
        if (!session('user')) {
            return redirect()->route('home')->with('showLogin', true);
        }
        return view('order.index');
    }
}
