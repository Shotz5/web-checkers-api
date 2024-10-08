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
            $request->session()->regenerate();

            return response('Auth successful', 200);
        }

        return response([
            'message' => 'The provided credentials do not match our records',
        ], 400);
    }

    public function status()
    {
        if (!Auth::check()) {
            return response("Not authenticated", 404);
        }

        $user = Auth::user();

        return response()->json([
            "name" => $user->name,
        ]);
    }

    /**
     * Logs the user out
     */
    public function destory(Request $request)
    {
        Auth::logout();

        // $request->user()->currentAccessToken()->delete();

        session()->invalidate();

        session()->regenerateToken();

        return response('Logged out', 200);
    }
}
