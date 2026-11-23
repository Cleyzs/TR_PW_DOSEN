<?php

namespace App\Http\Controllers;

use App\Support\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $kredensial = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ], Pesan::umum(), ['username' => 'Username', 'password' => 'Password']);

        if (Auth::attempt([
            'name'     => $kredensial['username'],
            'password' => $kredensial['password'],
        ], $request->boolean('ingat'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['username' => 'Username atau password salah.'])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
