<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        $remember = $request->boolean('remember');

        // Clear intended URL if it was pointing to login/register page
        $intendedUrl = session()->get('url.intended', '');
        if (str_contains($intendedUrl, '/login') || str_contains($intendedUrl, '/register')) {
            session()->forget('url.intended');
        }

        // Attempt 1: Standard authentication check
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Logged in successfully! Welcome back to BlogHub.');
        }

        // Attempt 2: Check if user already exists
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Check password for existing user
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user, $remember);
                $request->session()->regenerate();
                return redirect()->route('home')->with('success', 'Logged in successfully! Welcome back to BlogHub.');
            }

            // Return with explicit error message for incorrect password
            return redirect()->back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['password' => 'The password you entered is incorrect. Please try again.'])
                ->with('error', 'Login failed: Password does not match our records.');
        }

        // Attempt 3: Create account automatically for new user (demo helper)
        $newUser = User::create([
            'name' => ucfirst(explode('@', $request->email)[0]),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($newUser, $remember);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'New account created and logged in successfully! Welcome to BlogHub.');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Registration successful! Welcome to BlogHub.');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}

