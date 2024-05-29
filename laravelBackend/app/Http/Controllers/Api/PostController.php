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

    public function getPosts(Request $request)
    {
        $search = $request->query('search');
        $sortKey = $request->query('sortKey', 'title');
        $sortOrder = $request->query('sortOrder', 'asc');
        $minSalary = $request->query('minSalary', 0);
        $maxSalary = $request->query('maxSalary', 100000000);

        $userType = Auth::user()->type;

        $query = Post::with('business');

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhere('jobDesc', 'like', '%' . $search . '%')
                  ->orWhere('profession', 'like', '%' . $search . '%')
                  ->orWhere('country', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%');
        }

        $query->whereBetween('salaryRangeLowest', [$minSalary, $maxSalary]);

        $query->orderBy($sortKey, $sortOrder);

        $posts = $query->get();

        return response()->json([
            'status' => true,
            'posts' => $posts,
            'userType' => $userType
        ]);
    }

    public function getMyPosts(){
        $posts = Post::where('user_id', Auth::user()->id)->with('business')->get();

        $userType = Auth::user()->type;

        return response()->json([
            'status' => true,
            'posts' => $posts,
            'userType' => $userType
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

        if (Auth::user()->type === 'business' && $post && $post->user_id === Auth::user()->id) {
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

    public function deletePost(Request $request)
    {
        $post = Post::find($request->id);

        if (Auth::user()->type === 'business' && Auth::user()->id === $post->user_id) {
            $post->delete();

            return response()->json([
                'status' => true,
                'message' => 'Post deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Only business users can delete posts'
            ]);
        }
    }
}
