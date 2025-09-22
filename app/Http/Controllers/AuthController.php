<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login() {
        return view('auth.login');
    }

    public function login_action(Request $request) {
        $validate = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        $data = [
            'email' => $validate['email'],
            'password' => $validate['password'],
        ];

        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            if (Auth::user()->role == 'admin') {
                return redirect()->route('dashboard');
            }

            return redirect()->route('home');
        }

        return back()->withErrors([
            'login' => 'Email or Password incorrect'
        ])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
