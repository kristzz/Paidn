<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Education;

class EducationController extends Controller
{
    public function addEducation(Request $request){
        $request->validate([
            'educationProvider' => 'required',
            'levelOfEducation' => 'required',
            'fieldOfStudy' => 'required',
            'description' => 'nullable',
            'startDate' => 'required',
            'endDate' => 'required',
        ]);

        Education::create([
            'user_id' => Auth::user()->id,
            'educationProvider' => $request->educationProvider,
            'levelOfEducation' => $request->levelOfEducation,
            'fieldOfStudy' => $request->fieldOfStudy,
            'description' => $request->description,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Education added successfully'
        ]);
    }

    public function getEducation(Request $request){
        $user = Auth::user();

        $education = $user->education;
        return response()->json([
            'status' => true,
            'education' => $education
        ]);
    }

    public function deleteEducation(Request $request){
        $education = Education::find($request->id);
        $education->delete();

        return response()->json([
            'status' => true,
            'message' => 'Education deleted successfully'
        ]);
    }
}
