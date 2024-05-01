<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\RegularUser;

class RegularUserController extends Controller
{
    public function insertUserData(Request $request){
        $request->validate([
            'name' => 'max:50|required',
            'secondName' => 'max:50|nullable',
            'surname' => 'max:50|nullable',
            'gender' => 'required'
        ]);

        RegularUser::insert([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'secondName' => $request->secondName,
            'surname' => $request->surname,
            'gender'=> $request->gender,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User data inserted successfully'
        ]);
    }

    public function getUserProfile(){
        $userData = RegularUser::where('user_id', Auth::user()->id)->first();
        return response()->json([
            'status' => true,
            'userData' => $userData
        ]);
    }
}
