<?php

namespace App\Http\Controllers;

use App\Models\OTP;
use App\Models\User;
use App\Mail\OTPSendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class OTPController extends Controller
{
    /**
     * Show OTP Verification Page
     */
    public function showVerifyPage()
    {
        if (!Session::has('otp_email')) {
            return redirect()->route('auth')->with('error', 'Please enter your details first.');
        }

        return view('auth.otp-verify');
    }

    /**
     * Verify Registration OTP
     */
    public function verifyRegistration(Request $request)
    {
        $request->validate(['otp' => 'required|string|size:6']);

        $email = Session::get('otp_email');
        $otpData = OTP::where('email', $email)
            ->where('purpose', 'registration')
            ->latest()
            ->first();

        if (!$otpData || $otpData->otp !== $request->otp || $otpData->expires_at->isPast()) {
            return back()->with('error', 'Invalid or expired OTP.');
        }

        // Create User
        $userData = Session::get('registration_data');
        $user = User::create([
            'name' => $userData['name'],
            'email' => $email,
            'password' => $userData['password'], // Already hashed in AuthController
        ]);

        // Cleanup
        $otpData->delete();
        Session::forget(['otp_email', 'registration_data']);

        auth()->login($user);

        return redirect()->route('products.index')->with('success', 'Account verified and created successfully!');
    }

    /**
     * Handle Forgot Password Request
     */
    public function sendResetOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'This email is not registered with us.',
            'email.email' => 'Please enter a valid email address.',
            'email.required' => 'Email address is required.'
        ]);

        $email = $request->email;
        $otp = rand(100000, 999999);

        OTP::create([
            'email' => $email,
            'otp' => $otp,
            'purpose' => 'password_reset',
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        Mail::to($email)->send(new OTPSendMail($otp, 'password_reset'));

        Session::put('reset_email', $email);

        return redirect()->route('password.verify.page')->with('success', 'OTP has been sent to your email.');
    }

    /**
     * Show Password Reset OTP Verify Page
     */
    public function showPasswordVerifyPage()
    {
        if (!Session::has('reset_email')) {
            return redirect()->route('login');
        }
        return view('auth.pass-otp-verify');
    }

    /**
     * Verify Password Reset OTP
     */
    public function verifyResetOTP(Request $request)
    {
        $request->validate(['otp' => 'required|string|size:6']);

        $email = Session::get('reset_email');
        $otpData = OTP::where('email', $email)
            ->where('purpose', 'password_reset')
            ->latest()
            ->first();

        if (!$otpData || $otpData->otp !== $request->otp || $otpData->expires_at->isPast()) {
            return back()->with('error', 'Invalid or expired OTP.');
        }

        Session::put('otp_verified', true);
        return redirect()->route('password.reset.page');
    }

    /**
     * Show Reset Password Page
     */
    public function showResetPage()
    {
        if (!Session::get('otp_verified')) {
            return redirect()->route('login');
        }
        return view('auth.reset-password');
    }

    /**
     * Reset Password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $email = Session::get('reset_email');
        $user = User::where('email', $email)->first();
        $user->update(['password' => Hash::make($request->password)]);

        // Cleanup
        OTP::where('email', $email)->where('purpose', 'password_reset')->delete();
        Session::forget(['reset_email', 'otp_verified']);

        return redirect()->route('login')->with('success', 'Password reset successful. Please login with your new password.');
    }
}
