<?php

namespace App\Http\Middleware;
use App\Http\Requests\StoreAccountRequest;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMailVerification;
class VerifiedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();


        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Access Denied. Please log in to continue.',
                ], 401);
            }
            return redirect()->route('login.show')->with('error', 'Access Denied. Please login to continue.');
        }

        if (!$user->hasVerifiedEmail()) {
            session(['email' => $user->email]);

            if (!$user->otp) {
                $otp = random_int(1000, 9999);
                $user->otp = $otp;
                $user->save();

                Mail::to($user->email)->send(new OtpMailVerification($otp));
            }

            return redirect()->route('verification.show')->with('error', 'Please verify your email address using the OTP sent to your email.');

        }

        return $next($request);
    }


}
