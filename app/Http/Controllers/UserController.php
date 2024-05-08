<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function currentUser()
    {
        return response()->json([
            'user' => $this->getUser(Auth::id()),
        ]);
    }

    public function userList()
    {
        return response()->json([
            'users' => User::with(['pokemons'])->get()->except(Auth::id()),
        ]);
    }

    public function user(int $id)
    {
        return response()->json([
            'user' => $this->getUser($id)
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'username' => ['required', 'unique:users,username,' . Auth::id()],
            'email' => ['required', 'email', 'unique:users,email,' . Auth::id()],
            'birthday' => ['required'],
        ]);

        $user = Auth::user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->birthday = $request->birthday;
        $user->save();

        return response()->json([
            'user' => $user
        ]);
    }

    private function getUser($id)
    {
        return User::with(['pokemons'])->find($id);
    }
}
