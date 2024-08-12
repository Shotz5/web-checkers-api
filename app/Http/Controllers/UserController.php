<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('create');
    }

    public function create(Request $request)
    {
        $user = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'name' => ['required'],
        ]);

        $user = new User($user);
        $user->save();
        return redirect('/account/login');
    }
}
