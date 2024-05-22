<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Apply;
use App\Models\Post;

class ApplyController extends Controller
{
    public function applyForJob(Request $request)
    {
        $user = Auth::user();
        $post = Post::findOrFail($request->post_id); // Ensure post exists

        if ($user->type === 'user') {
            $appliedJob = new Apply();
            $appliedJob->user_id = $user->id;
            $appliedJob->post_id = $post->id;
            $appliedJob->save();

            return response()->json([
                'status' => true,
                'message' => 'Applied successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Only users can apply for jobs'
            ]);
        }
    }
}
