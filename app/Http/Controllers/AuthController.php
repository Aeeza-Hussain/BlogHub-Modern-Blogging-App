<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view()->first(['backend.auth.login', 'auth.login']);
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
            return redirect()->intended(route('dashboard.index'))->with('success', 'Logged in successfully! Welcome back to BlogHub.');
        }

        // Attempt 2: Check if user already exists
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Check password for existing user
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user, $remember);
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard.index'))->with('success', 'Logged in successfully! Welcome back to BlogHub.');
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

        return redirect()->intended(route('dashboard.index'))->with('success', 'New account created and logged in successfully! Welcome to BlogHub.');
    }

    public function showRegister()
    {
        $niches = [
            [
                'id' => 'ai',
                'name' => 'Artificial Intelligence (AI)',
                'icon' => 'fa-brain',
                'color' => '#7C3AED',
                'description' => 'Machine learning, generative AI, LLMs, neural networks & robotics',
            ],
            [
                'id' => 'tech',
                'name' => 'Technology & Coding',
                'icon' => 'fa-laptop-code',
                'color' => '#2563EB',
                'description' => 'Web development, software engineering, cloud, cybersecurity & devops',
            ],
            [
                'id' => 'sports',
                'name' => 'Sports & Fitness',
                'icon' => 'fa-futbol',
                'color' => '#DC2626',
                'description' => 'Football, cricket, gym workouts, athletics & active lifestyle',
            ],
            [
                'id' => 'cooking',
                'name' => 'Cooking & Food',
                'icon' => 'fa-utensils',
                'color' => '#D97706',
                'description' => 'Gourmet recipes, baking, restaurant reviews & culinary arts',
            ],
            [
                'id' => 'fashion',
                'name' => 'Fashion & Style',
                'icon' => 'fa-shirt',
                'color' => '#DB2777',
                'description' => 'Runway trends, seasonal styling, beauty, cosmetics & streetwear',
            ],
            [
                'id' => 'business',
                'name' => 'Business & Startups',
                'icon' => 'fa-chart-line',
                'color' => '#059669',
                'description' => 'Entrepreneurship, leadership, venture capital & market strategies',
            ],
            [
                'id' => 'finance',
                'name' => 'Finance & Crypto',
                'icon' => 'fa-coins',
                'color' => '#0D9488',
                'description' => 'Personal finance, stock markets, cryptocurrency & investment',
            ],
            [
                'id' => 'health',
                'name' => 'Health & Wellness',
                'icon' => 'fa-heart-pulse',
                'color' => '#10B981',
                'description' => 'Mental wellbeing, nutrition, fitness science & self-care',
            ],
            [
                'id' => 'travel',
                'name' => 'Travel & Tourism',
                'icon' => 'fa-plane-departure',
                'color' => '#3B82F6',
                'description' => 'Destination guides, backpacking, culture & wanderlust',
            ],
            [
                'id' => 'entertainment',
                'name' => 'Entertainment & Gaming',
                'icon' => 'fa-gamepad',
                'color' => '#8B5CF6',
                'description' => 'Video games, cinema reviews, pop culture, anime & streaming',
            ],
            [
                'id' => 'lifestyle',
                'name' => 'Culture & Lifestyle',
                'icon' => 'fa-book-open',
                'color' => '#E11D48',
                'description' => 'Books, philosophy, habits, mindful living & hobbies',
            ],
            [
                'id' => 'design',
                'name' => 'Design & Creative Arts',
                'icon' => 'fa-palette',
                'color' => '#C8461F',
                'description' => 'UI/UX design, visual branding, typography & digital art',
            ],
        ];

        return view()->first(['backend.auth.register', 'auth.register'], compact('niches'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'contact' => 'nullable|string|max:30',
            'gender' => 'nullable|string|in:male,female,other,prefer_not_to_say',
            'dob' => 'nullable|date|before:today',
            'niche' => 'nullable|string|max:100',
            'about' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:4096',
        ], [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please provide an email address.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'Please choose a password.',
            'password.min' => 'Password must be at least 6 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'dob.before' => 'Date of birth must be a past date.',
            'image.image' => 'The uploaded avatar must be an image file.',
            'image.mimes' => 'Avatar must be a JPEG, PNG, JPG, WebP, or GIF image.',
            'image.max' => 'Avatar size may not exceed 4MB.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('avatars', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'contact' => $validated['contact'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'dob' => $validated['dob'] ?? null,
            'niche' => $validated['niche'] ?? null,
            'about' => $validated['about'] ?? null,
            'image' => $imagePath,
        ]);

        // Automatically prepare author profile so user is ready to publish articles
        Author::firstOrCreate(
            ['name' => $user->name],
            [
                'slug' => Str::slug($user->name . '-' . rand(100, 999)),
                'avatar' => $user->avatar_url,
                'tagline' => $user->niche ? ($user->niche . ' Contributor') : 'BlogHub Author',
                'bio' => $user->about ?: 'Contributing author on BlogHub passionate about sharing insights and perspectives.',
                'specialty' => $user->niche ?: 'General Topics',
            ]
        );

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard.index')->with('success', 'Registration successful! Welcome to BlogHub, ' . $user->name . '.');
    }

    public function showForgotPassword()
    {
        return view()->first(['backend.auth.forgot-password', 'auth.forgot-password']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}

