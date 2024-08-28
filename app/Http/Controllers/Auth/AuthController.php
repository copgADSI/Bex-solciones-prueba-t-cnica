<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
            'password.required' => 'Password is required',
        ]);

        $credentials = $request->only('email', 'password');

        // Intentar autenticar al usuario
        if (auth()->attempt($credentials)) {
            $user = $request->user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
                'message' => 'Login successful'
            ], Response::HTTP_OK);
        }

        return response()->json([
            'error' => 'Unauthorized',
            'message' => 'Email or password is incorrect'
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        auth()->logout();

        return redirect()->route('home')->with('status', 'Logged out successfully!');
    }
}
