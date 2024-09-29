<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function ShowRegistrationForm()
    {
        return view('auth.register.register');
    }

    public function StoreAccount(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'employee_id' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->employee_id = $request->employee_id;
        $user->password = Hash::make($request->password);
        $user->save();


        return redirect()->route('login.show')->with('success', 'Registration successful!');
    }

    public function ShowLogin()
    {
        return view('auth.login.login');
    }

    public function Login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();


            if (Auth::user()->isAdmin) {

                return redirect()->intended(route('admin.home.show'));

            } else {

                return redirect()->intended(route('')); // Ensure you have this route defined
            }
        }

        return back()->withErrors([

        ]);
    }

}
