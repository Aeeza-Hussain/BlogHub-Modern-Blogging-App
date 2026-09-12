<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        return redirect()->route('home')->with('success', 'Logged in successfully! Welcome back to BlogHub.');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'password' => 'required|min:6|confirmed',
            'terms' => 'accepted',
        ]);

        return redirect()->route('home')->with('success', 'Registration successful! Welcome to BlogHub.');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }
}
