<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;

class PostController extends Controller
{
    public function post(Request $request){
        $request->validate([
            'title' => 'required',
            'jobDesc' => 'required',
            'profession' => 'required',
            'salaryRangeLowest' => 'required',
            'salaryRangeHighest' => 'required',
        ]);

        Post::create([
            'title' => $request->title,
            'jobDesc' => $request->jobDesc,
            'profession' => $request->profession,
            'salaryRangeLowest' => $request->salaryRangeLowest,
            'salaryRangeHighest' => $request->salaryRangeHighest,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Post created successfully'
        ]);
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
