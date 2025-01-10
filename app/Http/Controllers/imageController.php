<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string|max:255',
            'user_name' => 'nullable|string|max:255',
        ]);
    
        $destinationPath = public_path('assets/images');

    
        $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
    
        $request->file('image')->move($destinationPath, $fileName);
    
        $image = Image::create([
            'image_path' => 'assets/images/' . $fileName, 
            'description' => $request->input('description'),
            'user_name' => $request->input('user_name'),
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Image uploaded successfully',
            'image' => $image,
        ]);
    }
    

    // Method to view an image
    public function getAllImages()
    {
        $images = Image::all();
    
        $imageUrls = $images->map(function ($image) {
            return [
                'id' => $image->id,
                'image_url' => url($image->image_path), 
                'description' => $image->description,
                'user_name' => $image->user_name,
                'created_at' => $image->created_at->toDateTimeString(),
            ];
        });
    
        return response()->json($imageUrls);
    }
    

    
}
