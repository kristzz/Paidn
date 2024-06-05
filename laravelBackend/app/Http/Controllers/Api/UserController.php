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
                'token' => $token,
                'type' => $user->type,
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
            'data' => $user,

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


    public function getUsers()
    {
        // Ensure the user is an admin
        if (Auth::user()->type !== 'admin') {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $users = User::all();

        return response()->json([
            'status' => true,
            'users' => $users
        ]);
    }

    // Admin method to delete a user by ID
    public function deleteUserAdmin($id)
    {
        // Ensure the user is an admin
        if (Auth::user()->type !== 'admin') {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found'], 404);
        }

        try {
            $user->delete();
            return response()->json(['status' => true, 'message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
