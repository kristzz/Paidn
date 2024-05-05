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

    public function editEducationExperience(Request $request){
        $education = Education::find($request->id);

        $request->validate([
            'educationProvider' => 'required',
            'levelOfEducation' => 'required',
            'fieldOfStudy' => 'required',
            'description' => 'nullable',
            'startDate' => 'required',
            'endDate' => 'required',
        ]);
        if (Auth::user()->type === 'user') {
            $education->educationProvider = $request->educationProvider;
            $education->levelOfEducation = $request->levelOfEducation;
            $education->fieldOfStudy = $request->fieldOfStudy;
            $education->description = $request->description;
            $education->startDate = $request->startDate;
            $education->endDate = $request->endDate;
            $education->save();

            return response()->json([
                'status' => true,
                'message' => 'Education updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Only user users can edit education experience'
            ]);
        }
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
