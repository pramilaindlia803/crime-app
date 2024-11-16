<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/upload-image', [ImageController::class, 'uploadImage']);
Route::get('/images', [ImageController::class, 'getAllImages']);
