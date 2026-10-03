<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\ContactMessage;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $team = Author::take(4)->get();
        return view('about', compact('team'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create($validated);

        return redirect()->back()->with('success', 'Thank you for contacting us! We will respond shortly.');
    }

    public function privacy()
    {
        return view('legal.privacy');
    }

    public function terms()
    {
        return view('legal.terms');
    }

    public function subscribeNewsletter(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:150',
        ]);

        $existing = Subscriber::where('email', $validated['email'])->first();

        if ($existing) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'info',
                    'message' => 'You are already subscribed to our newsletter! ✨'
                ]);
            }
            return redirect()->back()->with('status', 'You are already subscribed to our newsletter! ✨');
        }

        Subscriber::create(['email' => $validated['email']]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Thank you for subscribing! You will receive our latest digests. 🎉'
            ]);
        }

        return redirect()->back()->with('success', 'Thank you for subscribing to our newsletter! 🎉');
    }
}
