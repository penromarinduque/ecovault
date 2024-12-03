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
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Http\Requests\AuthenticateRequest;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function ShowRegistrationForm()
    {
        return view('auth.register.register');
    }

    public function storeAccount(StoreAccountRequest $request)
    {
        try {
            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'employee_id' => $request->employee_id,
                'password' => Hash::make($request->password),
            ]);

            // Generate and assign OTP
            $otp = random_int(1000, 9999);
            $user->otp = $otp;
            $user->save();

            // Store email in session
            session(['email' => $request->email]);

            // Send verification email
            try {
                Mail::to($request->email)->send(new OtpMailVerification($otp));
            } catch (\Exception $emailException) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Account created, but failed to send verification email.',
                ], 400);
            }
            $message = 'Account created successfully. Please check your email for the OTP.';

            session()->flash('success', $message);

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => $message,
                'redirect' => route('verification.show'),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create account. Please try again later.',
            ], 500);
        }
    }




    public function ShowLogin()
    {
        return view('auth.login.login');
    }

    public function Authenticate(AuthenticateRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Attempt login using Auth::attempt
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Log the user activity
            activity()
                ->causedBy(auth()->user())  // The authenticated user
                ->performedOn(auth()->user())  // Log the activity on the user model
                ->log('User logged in');  // Custom message

            $request->session()->regenerate();

            // Return a JSON response for successful login
            return response()->json([
                'status' => 'success',
                'redirect' => route('admin.home.show'), // Redirect to the intended route
            ], 200);
        }

        // If authentication fails, return an error message
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials. Please check your email and password.',
        ], 401); // HTTP 401 Unauthorized status
    }


    public function ShowVerification()
    {
        $email = session('email');
        return view('auth.verification.verification', ['email' => $email]);
    }

    public function resendOtp(Request $request)
    {
        // Validate the email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email', // Ensure email exists in the users table
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        // Get the user based on email
        $user = User::where('email', $request->email)->first();

        // Generate and assign OTP
        $otp = random_int(1000, 9999);
        $user->otp = $otp;
        $user->save();

        // Store email in session
        session(['email' => $request->email]);

        // Send verification email
        try {
            Mail::to($request->email)->send(new OtpMailVerification($otp));
            return response()->json([
                'success' => 'success',
                'message' => 'OTP has been sent to your email.',
            ], 200);
        } catch (\Exception $emailException) {
            return response()->json([
                'error' => 'error',
                'message' => 'Failed to send verification email.',
            ], 500); // Return 500 for server errors
        }
    }
    public function VerifyEmail(Request $request)
    {
        $request->validate([
            'otp' => 'required|array|size:4',
            'otp.*' => 'required|digits:1',
        ]);

        $otp = implode('', $request->input('otp'));
        $email = session('email');

        if (!$email) {
            return response()->json(['message' => 'Email not found in session.'], 422);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        if ($otp === $user->otp) {
            $user->email_verified_at = now();
            $user->otp = null;
            $user->save();

            Auth::login($user);
            $message = 'Welcome! new User';

            session()->flash('success', $message);
            return response()->json([
                'message' => 'Your account has been verified successfully.',
                'redirect_url' => route('admin.home.show'),
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'OTP is incorrect.'
        ], 400);
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
        return redirect()->route('login.show')->with('success', 'Logout Successful');
    }


    public function SendPassResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['error' => __($status)]);
    }

    public function ShowResetForm(Request $request, string $token)
    {
        return view('auth.forgot-password.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function ResetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Ensure the user exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No user found with this email address.']);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login.show')->with('success', __($status))
            : back()->withErrors(['error' => [__($status)]]);
    }
}
