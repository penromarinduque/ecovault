<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class VerifiedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (Auth::check() && !Auth::user()->hasVerifiedEmail()) {
            // If the request is an AJAX request, return a JSON response

            // if ($request->expectsJson()) {
            //     return response()->json([
            //         'message' => 'Email verification required.'
            //     ], 403);
            // }
            return redirect()->route('verification.show')->withErrors(['error' => 'Email verification required.']);
        }

        if (!$user) {
            return redirect('/login')->withErrors(['error' => 'Access Denied']);
        }

        return $next($request);
    }
}
