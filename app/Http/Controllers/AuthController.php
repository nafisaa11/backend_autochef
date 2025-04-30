<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // function showregristrasi()
    // {
    //     return view('regristrasi');
    // }

    // function submitregristrasi(Request $request)
    // {
    //     $user = new User();
    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->password = bcrypt($request->password);
    //     $user->save();
    //     // dd($user);
    //     return redirect()->route('login.show');
    // }

    // function showlogin()
    // {
    //     return view('login');
    // }

    // // function submitlogin(Request $request)
    // // {
    // //     $data = $request->only('email', 'password');

    // //     if (Auth::attempt($data)) {
    // //         $request->session()->regenerate();
    // //         return redirect()->route('index');
    // //     }
    // // }

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
    
        return response()->json(['message' => 'Akun berhasil dibuat', 'user' => $user]);
    }
    
    public function login(Request $request) {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Login gagal'], 401);
        }
    
        $user = Auth::user();
        return response()->json(['message' => 'Login berhasil', 'user' => $user]);
    }
    

}


