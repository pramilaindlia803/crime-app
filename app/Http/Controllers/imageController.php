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

    // Store the image in the 'public/images' directory
    $path = $request->file('image')->store('images', 'public');

    // Save the image details in the database
    $image = Image::create([
        'image_path' => $path,
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
            'image_url' => \Illuminate\Support\Facades\Storage::url($image->image_path),
            'description' => $image->description,
            'user_name' => $image->user_name,
            'created_at' => $image->created_at->toDateTimeString(),
        ];
    });

    return response()->json($imageUrls);
}

    
}
