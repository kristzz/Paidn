<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Apply;

class ApplyController extends Controller
{
    public function applyForJob(){
        $user = Auth::user();
        if ($user->type === 'user'){
            Apply::create([
                'user_id' => $user->id,
                'post_id' => $user->posts->id,
            ]);

            response()->json([
                'status' => true,
                'message' => 'Applied successfully'
            ]);
        }else{
            response()->json([
                'status' => false,
                'message' => 'Only users can apply for jobs'
            ]);
        }
    }
}
