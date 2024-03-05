<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Business;

class BusinessController extends Controller
{
    //Post
    public function register(Request $request){
        $request->validate([
            'businessName' => 'required|string',
            'businessType' => 'required|string',
            'businessAddress' => 'string',
            'businessDescription' => 'string',
            'businessEmail' => 'required|email|unique:businesses',
            'businessPassword' => 'required|confirmed'
        ]);

        Business::create([
            'businessName' => $request->businessName, // Corrected to match the validation
            'businessType' => $request->businessType,
            'businessAddress' => $request->businessAddress,
            'businessDescription' => $request->businessDescription,
            'businessEmail' => $request->businessEmail,
            'businessPassword' => Hash::make($request->businessPassword) // Ensure this matches the validation
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Business user created successfully'
        ]);
    }

    public function login(Request $request){
        $request->validate([
            'businessEmail' => 'required|email',
            'businessPassword' => 'required'
        ]);

        if(Auth::attempt([
            'businessEmail' => $request->email,
            'businessPassword' => $request->password
        ])){
            $user = Auth::user();
            $token = $user->createToken('myToken')->accessToken;

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
        $user = Auth::user();

        auth()->user()->token()->revoke();

        return response()->json([
            'status' => true,
            'message' => 'User logged out'
        ]);
    }
}
