<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OTP;
use App\Mail\OTPSendMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AdminAuthController extends Controller
{
    // Show admin registration form
    public function showRegisterForm()
    {
        return view('admin-auth', ['activeTab' => 'register']);
    }

    // Handle admin registration (Step 1: Send OTP)
    public function register(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'admin_key' => 'required|string',
            'terms' => 'required',
        ]);

        // Check security key
        $validAdminKey = env('ADMIN_SECRET_KEY', 'MyStore@2026');
        
        if ($request->admin_key !== $validAdminKey) {
            return back()->withErrors([
                'admin_key' => 'Invalid security key. Access denied.',
            ])->withInput();
        }

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
            'purpose' => 'admin_registration',
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Send OTP via Email
        Mail::to($email)->send(new OTPSendMail($otp, 'admin_registration'));

        // Store registration data in session
        Session::put('admin_registration_data', [
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($request->password),
        ]);
        Session::put('admin_otp_email', $email);

        // Redirect to admin OTP verification page
        return redirect()->route('admin.otp.verify')->with('success', 'OTP has been sent to your email.');
    }

    // Show admin OTP verification page
    public function showOTPVerifyPage()
    {
        if (!Session::has('admin_otp_email')) {
            return redirect()->route('admin.register')->with('error', 'Please enter your details first.');
        }

        return view('auth.admin-otp-verify');
    }

    // Handle admin OTP verification (Step 2: Create User)
    public function verifyOTP(Request $request)
    {
        $request->validate(['otp' => 'required|string|size:6']);

        $email = Session::get('admin_otp_email');
        $otpData = OTP::where('email', $email)
            ->where('purpose', 'admin_registration')
            ->latest()
            ->first();

        if (!$otpData || $otpData->otp !== $request->otp || $otpData->expires_at->isPast()) {
            return back()->with('error', 'Invalid or expired OTP.');
        }

        // Create Admin User
        $userData = Session::get('admin_registration_data');
        $user = User::create([
            'name' => $userData['name'],
            'email' => $email,
            'password' => $userData['password'],
            'role' => 'admin',
            'is_admin' => true,
        ]);

        // Cleanup
        $otpData->delete();
        Session::forget(['admin_otp_email', 'admin_registration_data']);

        auth()->login($user);

        return redirect()->route('admin.dashboard')->with('success', 'Admin account created and verified successfully!');
    }

    // Show admin login form
    public function showLoginForm()
    {
        return view('admin-auth', ['activeTab' => 'login']);
    }

    // Handle admin login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if user exists and is admin
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            
            // Check if user has admin role
            if ($user->role === 'admin' || $user->is_admin === true) {
                return redirect()->route('admin.dashboard');
            } else {
                auth()->logout();
                return back()->withErrors([
                    'email' => 'You do not have admin access.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    // Handle admin logout
    public function logout()
    {
        auth()->logout();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
