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

        $user = Auth::user();

        if ($user->type === 'business' && $user->business) {
            Post::create([
                'user_id' => $user->id,
                'business_id' => $user->business->id,
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
                'message' => 'Only business users with registered businesses can create posts'
            ]);
        }
    }

    public function getPosts(){
        $posts = Post::with('business')->get();

        return response()->json([
            'status' => true,
            'posts' => $posts
        ]);
    }

    public function getMyPosts(){
        $posts = Post::where('user_id', Auth::user()->id)->with('business')->get();

        return response()->json([
            'status' => true,
            'posts' => $posts
        ]);
    }

    public function editPosts(Request $request){
        $post = Post::find($request->id);

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
            $post->title = $request->title;
            $post->jobDesc = $request->jobDesc;
            $post->profession = $request->profession;
            $post->country = $request->country;
            $post->location = $request->location;
            $post->salaryRangeLowest = $request->salaryRangeLowest;
            $post->salaryRangeHighest = $request->salaryRangeHighest;
            $post->save();

            return response()->json([
                'status' => true,
                'message' => 'Post updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Only business users can edit posts'
            ]);
        }
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
