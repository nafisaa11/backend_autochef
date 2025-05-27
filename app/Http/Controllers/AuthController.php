<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
        ]);
    
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $token = $user->createToken('auth-token-' . $user->id)->plainTextToken;
    
        return response()->json([
            'message' => 'Akun berhasil dibuat', 
            'user' => $user,
            'token' => $token
        ], 201);
    }
    
    public function login(Request $request) {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Login gagal'], 401);
        }
    
        $user = Auth::user();

        $token = $user->createToken('api-auth-token-' . $user->id)->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil', 
            'user' => $user,
            'token' => $token   
        ], 200);
    }
    

}


