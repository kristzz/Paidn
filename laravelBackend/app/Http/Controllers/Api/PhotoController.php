<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $name = Str::random(10) . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('images', $name, 'public');

            $image = new Photo;
            $image->file_path = $path;
            $image->save();

            return response()->json("Uploaded successfully!");
        }
    }

    public function remove(Request $request)
    {
        $image = Photo::where('file_path', 'images/' . $request->name)->first();

        if ($image) {
            Storage::disk('public')->delete($image->file_path);
            $image->delete();

            return response()->json("Removed successfully");
        }

        return response()->json("Image not found", 404);
    }
}
