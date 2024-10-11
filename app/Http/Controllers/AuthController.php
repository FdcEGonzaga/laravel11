<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    public function register(Request $request) {
        // - validate
        $fields = $request->validate([
            "user_name" =>  ['required', 'max:30'],
            "email" =>  ['required', 'max:30', 'email', 'unique:users'],
            "password" =>  ['required', 'min:5', 'confirmed']
        ]);


        // - register
        $user = User::create($fields);

        // - login
        Auth::login($user);

        // - redirect
        redirect()->route('dashboard');
    }

    public function login(Request $request) {
        // - validate
        $fields = $request->validate([
            "email" =>  ['required', 'max:30', 'email'],
            "password" =>  ['required']
        ]);

        // - login
        if (Auth::attempt($fields, $request->remember)) {
            return redirect()->intended('dashboard');
        } else {
            return back()->withErrors([
                "failed" => "The provided credentials do not match our records. Please try again."
            ]);
        }
    }

    public function logout(Request $request) {
        Auth::logout();

        // - invalidate user's session
        $request->session()->invalidate();

        // - regenerate CSRF token
        $request->session()->regenerateToken();

        // - redirect to home
        return redirect('/');
    }
}