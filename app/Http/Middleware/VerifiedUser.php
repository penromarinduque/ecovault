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
        // Ensure user is authenticated
        $user = $request->user();

        // If the user is not authenticated or their email is not verified
        if (!$user || !$user->hasVerifiedEmail()) {
            $route = $user ? 'verification.show' : 'login.show'; // Redirect to either verification or login
            $message = $user ? 'Email verification required.' : 'Access Denied'; // Custom message based on condition

            return redirect()->route($route)->withErrors(['error' => $message]);
        }

        // Continue with the request if all checks pass
        return $next($request);
    }
}
