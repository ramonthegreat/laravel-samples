<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            return response()->json([
                'user' => $user,
                'token' => $user->createToken('access_token', ['access-api'], now()->addWeek())->plainTextToken,
                'refresh_token' => $user->createToken('refresh_token', ['issue-access-token'], now()->addMonth())->plainTextToken
            ]);
        }

        throw ValidationException::withMessages(['The provided credentials are incorrect']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'username' => ['required', 'unique:users,username'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
            'birthday' => ['required'],
        ]);

        /** @var User $user */
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthday' => $request->birthday,
        ]);

        Auth::login($user);

        return response()->json([
            'user' => Auth::user(),
            'token' => $user->createToken('access_token', ['access-api'], now()->addWeek())->plainTextToken,
            'refresh_token' => $user->createToken('refresh_token', ['issue-access-token'], now()->addMonth())->plainTextToken
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ]);
    }

    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json([
            'token' => $user->createToken('access_token', ['access-api'], now()->addWeek())->plainTextToken,
            'refresh_token' => $user->createToken('refresh_token', ['issue-access-token'], now()->addMonth())->plainTextToken
        ]);
    }
}
