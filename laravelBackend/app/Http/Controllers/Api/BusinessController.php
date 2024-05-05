<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Business;

class BusinessController extends Controller
{
    public function insertBusiness(Request $request){
        $request->validate([
            'businessName' => 'max:50|required',
            'businessType' => 'max:50|required',
            'businessAddress' => 'required',
            'businessDescription' => 'required',
        ]);
        if (Auth::user()->type === 'business') {
            Business::create([
                'user_id' => Auth::user()->id,
                'businessName' => $request->businessName,
                'businessType' => $request->businessType,
                'businessAddress' => $request->businessAddress,
                'businessDescription' => $request->businessDescription,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Business data inserted successfully'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Only business users can create business profiles'
            ]);
        }

    }

    public function getBusinessProfile(){
        $businessData = Business::where('user_id', Auth::user()->id)->first();
        return response()->json([
            'status' => true,
            'businessData' => $businessData
        ]);
    }
}
