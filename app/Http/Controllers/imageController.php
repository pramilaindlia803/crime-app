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
        ]);

        // Store the image in the 'public/images' directory
        $path = $request->file('image')->store('images', 'public');

        // Save the image path in the database
        $image = Image::create([
            'image_path' => $path,
        ]);

        return response()->json(['success' => true,
         'message' => 'Image uploaded successfully', 
         'image' => $image]);
    }

    // Method to view an image
    public function getAllImages()
    {
        $images = Image::all();
    
        // Transform the image records to include full URL for each image
        $imageUrls = $images->map(function ($image) {
            return [
                'id' => $image->id,
                'image_url' => \Illuminate\Support\Facades\Storage::url($image->image_path)
            ];
        });
    
        return response()->json($imageUrls);
    }
    
}
