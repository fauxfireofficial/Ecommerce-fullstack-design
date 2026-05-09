<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Subscriber;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'You are already in our subscription list!',
        ]);

        Subscriber::create([
            'email' => $request->email,
        ]);

        return back()->with('success', 'Thank you! You will now receive updates on our latest offers.');
    }
}
