<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Login user and generate token
    public function login(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
                'status' => 401,
                'data' => null
            ], 401);
        }

        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return token as response
        return response()->json([
            'message' => 'Login successful',
            'status' => 200,
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ]);
    }

    // Register new user
    public function register(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return user and token as response
        return response()->json([
            'message' => 'User registered successfully',
            'status' => 201,
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 201);
    }
}
