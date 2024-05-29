<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\RegularUser;

class RegularUserController extends Controller
{
    public function editRegularUser(Request $request)
    {
        $request->validate([
            'name' => 'max:50|required',
            'secondName' => 'max:50|nullable',
            'surname' => 'max:50|nullable',
            'age' => 'required',
            'nationality' => 'required',
            'gender' => 'required'
        ]);

        if (Auth::user()->type === 'user') {
            $regularUser = RegularUser::firstOrNew(['user_id' => Auth::user()->id]);
            $regularUser->name = $request->name;
            $regularUser->secondName = $request->secondName;
            $regularUser->surname = $request->surname;
            $regularUser->age = $request->age;
            $regularUser->nationality = $request->nationality;
            $regularUser->gender = $request->gender;
            $regularUser->save();

            return response()->json([
                'status' => true,
                'message' => 'User data updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Only regular users can update user profiles'
            ]);
        }
    }

    public function getUserProfile(){
        $userData = RegularUser::where('user_id', Auth::user()->id)->first();
        return response()->json([
            'status' => true,
            'userData' => $userData
        ]);
    }
}
