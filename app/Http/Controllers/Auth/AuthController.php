<?php

namespace App\Http\Controllers\Auth;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMailVerification;
class AuthController extends Controller
{
    public function ShowRegistrationForm()
    {
        return view('auth.register.register');
    }

    public function StoreAccount(StoreAccountRequest $request)
    {
        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'employee_id' => $request->employee_id,
                'password' => Hash::make($request->password),
            ]);


            $otp = random_int(1000, 9999);
            $user->otp = $otp;
            $user->save();

            session(['email' => $request->email]);

            Mail::to($request->email)->send(new OtpMailVerification($otp));


            return redirect()->route('verification.show')
                ->with('message', 'Account created successfully. Please check your email for the OTP.');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Failed to create account or send verification email. Please try again later.'
                ], 500);
            }

            // Fallback for regular form submission
            return redirect()->route('verification.show')
                ->withErrors(['error' => 'Failed to send verification email. Please try again later.']);
        }
    }

    public function ShowLogin()
    {
        return view('auth.login.login');
    }

    public function Authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Log the user state after successful login
            \Log::info('User authenticated: ', ['email' => $request->email]);

            $request->session()->regenerate();

            return redirect()->intended(route('admin.home.show'));
        }

        // Log the failed attempt
        \Log::warning('Failed authentication attempt: ', ['email' => $request->email]);

        return back()->withErrors([]);
    }

    public function ShowVerification()
    {
        $email = session('email');
        return view('auth.verification.verification', ['email' => $email]);
    }


    public function VerifyEmail(Request $request)
    {

        $request->validate([
            'otp' => 'required|array|size:4', // Ensure it's an array of exactly 4 elements
            'otp.*' => 'required|digits:1',   // Each element must be a single digit
        ]);


        $otpArray = $request->input('otp');
        $otp = implode('', $otpArray);


        $email = session('email');

        if (!$email) {

            return response()->json(['message' => 'Email not found in session.'], 422);
        }


        $user = User::where('email', $email)->first();

        if (!$user) {

            return response()->json(['message' => 'User not found.'], 404);
        }


        if ($otp == $user->otp) {

            $user->email_verified_at = now();
            $user->otp = null;
            $user->save();


            session()->forget('email');

            return redirect()->intended(route('login.show'));
        } else {
            return response()->json(['message' => 'OTP is incorrect.'], 422);
        }
    }

    public function Logout(Request $request)
    {

        $user = Auth::user();

        if ($user) {
            $user->remember_token = null;
            $user->save();
        }

        Auth::logout();


        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.show')->with('status', 'Logout Successful');
    }
}
