<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Shows the login page
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Authenticates the user
     */
    public function create(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->validate([
            'remember' => ['required', 'boolean'],
        ]);

        if (Auth::attempt($credentials, $remember['remember'])) {
            session()->regenerate();

            return response('Auth successful', 200);
        }

        return response([
            'email' => 'The provided credentials do not match our records',
        ], 400);
    }
}
