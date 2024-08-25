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
            'username' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
            'name' => ['required'],
        ]);

        $user = new User($user);
        $user->save();
        return response()->json('success');
    }

    public function search(Request $request)
    {
        $search = $request->validate([
            'username' => ['required'],
        ]);

        $users = User::where('username', 'LIKE', '%' . $search['username'] . '%')->get(['username']);

        return response()->json($users->toArray());
    }
}
