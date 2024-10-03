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

            Auth::login($user);

            Mail::to($request->email)->send(new OtpMailVerification($otp));


            return redirect()->route('verification.show')
                ->with('message', 'Account created successfully. Please check your email for the OTP.');

        } catch (\Exception $e) {
            // Log the exception
            \Log::error('Account creation failed: ' . $e->getMessage());

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
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('home.show'));
        }

        return back()->withErrors([

        ]);
    }

    public function ShowVerification()
    {
        return view('auth.verification.verification');
    }


    public function VerifyEmail(Request $request)
    {
        // Validate that 'otp' is an array with exactly 4 numeric characters
        $request->validate([
            'otp' => 'required|array|size:4', // Ensure it's an array of exactly 4 elements
            'otp.*' => 'required|digits:1', // Each element must be a single digit
        ]);

        // Combine the OTP digits into a single string
        $otpArray = $request->input('otp');
        $otp = implode('', $otpArray);


        $user = Auth::user();
        // Check if the user is authenticated and if the OTP matches
        if ($user && $otp == $user->otp) {
            // Success - OTP is correct, update email_verified_at
            $user->email_verified_at = now();
            $user->otp = null; // Clear OTP after verification
            $user->save();

            return response()->json(['message' => 'Email verified successfully.'], 200);
        } else {
            // Failure - OTP is incorrect
            return response()->json(['message' => 'OTP is incorrect.'], 422);
        }
    }
}
