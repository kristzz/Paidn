<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Post;

class PostController extends Controller
{
    public function post(Request $request){
        $request->validate([
            'title' => 'required',
            'jobDesc' => 'required',
            'profession' => 'required',
            'country' => 'required',
            'location' => 'required',
            'salaryRangeLowest' => 'required',
            'salaryRangeHighest' => 'required',
        ]);

        if (Auth::user()->type === 'business') {
            Post::create([
                'user_id' => Auth::user()->id,
                'title' => $request->title,
                'jobDesc' => $request->jobDesc,
                'profession' => $request->profession,
                'country' => $request->country,
                'location' => $request->location,
                'salaryRangeLowest' => $request->salaryRangeLowest,
                'salaryRangeHighest' => $request->salaryRangeHighest,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Post created successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Only business users can create posts'
            ]);
        }
    }

    public function getPosts(){
        $posts = Post::all();

        return response()->json([
            'status' => true,
            'posts' => $posts
        ]);
    }

    public function deletePost(Request $request){
        $post = Post::find($request->id);
        $post->delete();

        return response()->json([
            'status' => true,
            'message' => 'Post deleted successfully'
        ]);
    }
}
