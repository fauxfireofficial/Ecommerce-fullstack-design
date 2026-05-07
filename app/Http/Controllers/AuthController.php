<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OTP;
use App\Mail\OTPSendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Show the login/register form.
     */
    public function showAuthForm()
    {
        $activeTab = request()->routeIs('register') ? 'register' : 'login';
        return view('auth', compact('activeTab'));
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(6),
                'regex:/[0-9\W]/', // At least one number or special character
            ],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Generate OTP
        $otp = rand(100000, 999999);
        $email = $request->email;

        // Store OTP in database
        OTP::create([
            'email' => $email,
            'otp' => $otp,
            'purpose' => 'registration',
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Send Email
        Mail::to($email)->send(new OTPSendMail($otp, 'registration'));

        // Save data in session temporarily
        session()->put('otp_email', $email);
        session()->put('registration_data', [
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('otp.verify.page')->with('success', 'OTP has been sent to your email.');
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
