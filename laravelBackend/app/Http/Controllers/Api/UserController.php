<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserController extends Controller
{
    //Post
    public function register(Request $request){
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'type' => 'required|in:user,business',
        ]);

        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully'
        ]);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            $user = Auth::user();
            $token = $user->createToken('authToken')->accessToken;

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'token' => $token
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials'
            ]);
        }
    }
    //Get
    public function profile(){
        $user = Auth::user();

        return response()->json([
            'status' => true,
            'message' => 'User profile',
            'data' => $user
        ]);
    }

    public function logout(){
        auth()->user()->token()->revoke();

        return response()->json([
            'status' => true,
            'message' => 'User logged out'
        ]);
    }

    public function deleteUser(){
        $user = Auth::user();

        try {
            $user->delete();
            auth()->user()->token()->revoke();

            return response()->json(['message' => 'Account deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
