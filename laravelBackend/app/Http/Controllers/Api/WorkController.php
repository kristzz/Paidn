<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Work;

class WorkController extends Controller
{
    public function addWorkExperience(Request $request){
        $request->validate([
            'workPositionName' => 'required',
            'companyName' => 'required',
            'fieldOfWork' => 'required',
            'description' => 'nullable',
            'startDate' => 'required',
            'endDate' => 'required',
        ]);

        Work::create([
            'user_id' => Auth::user()->id,
            'workPositionName' => $request->workPositionName,
            'companyName' => $request->companyName,
            'fieldOfWork' => $request->fieldOfWork,
            'description' => $request->description,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Work added successfully'
        ]);
    }

    public function getWorkExperience(Request $request){
        $user = Auth::user();
        $work = $user->work;

        return response()->json([
            'status' => true,
            'work' => $work
        ]);
    }

    public function editWorkExperience(Request $request){
       $work = Work::find($request->id);

       $request->validate([
           'workPositionName' => 'required',
           'companyName' => 'required',
           'fieldOfWork' => 'required',
           'description' => 'nullable',
           'startDate' => 'required',
           'endDate' => 'required',
       ]);
       if (Auth::user()->type === 'user') {
        $work->workPositionName = $request->workPositionName;
        $work->companyName = $request->companyName;
        $work->fieldOfWork = $request->fieldOfWork;
        $work->description = $request->description;
        $work->startDate = $request->startDate;
        $work->endDate = $request->endDate;
        $work->save();

        return response()->json([
            'status' => true,
            'message' => 'Work experience edited successfully'
        ]);
       }else {
              return response()->json([
                'status' => false,
                'message' => 'Only users can edit work experience'
              ]);
       }
    }

    public function deleteWorkExperience(Request $request){
        $work = Work::find($request->id);
        $work->delete();

        return response()->json([
            'status' => true,
            'message' => 'Work deleted successfully'
        ]);
    }
}
