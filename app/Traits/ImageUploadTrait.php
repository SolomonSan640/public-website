<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait ImageUploadTrait
{
    public function singleImage($request, $imageName, $folderName)
    {
        if ($request->hasFile($imageName)) {
            $image = $request->file($imageName);
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/' . $folderName), $imageName);
            return $folderName . '/' . $imageName;
        }
        return null;
    }

    public function base64($request, $imageName, $folderName)
    {
        // if ($request->has('image')) {
        //     $image = $request->image;  // your base64 encoded image
        //     $image = str_replace('data:image/png;base64,', '', $image);
        //     $image = str_replace(' ', '+', $image);
        //     $imageName = Str::random(10) . '.png';
        //     $filePath = 'images/' . $folderName . '/' . $imageName;

        //     // Decode and save the base64 image to storage
        //     \File::put(public_path($filePath), base64_decode($image));

        //     // Return the file path or URL if needed
        //     return $filePath; // or Storage::url($filePath) for URL
        // }

        // return null;

        $base64Image = $request->input('image');

        if ($base64Image) {
            // Check if base64 string contains metadata
            if (strpos($base64Image, ';base64,') !== false) {
                list($meta, $base64Image) = explode(';base64,', $base64Image);
            }
    
            // Decode the base64 image
            $image = base64_decode($base64Image);
    
            if ($image === false) {
                Log::error('Base64 decoding failed.');
                return response()->json(['status' => 400, 'message' => 'Invalid base64 string'], 400);
            }
    
            $imageName = Str::random(10) . '.png';
            $filePath = public_path('images/users/' . $imageName); // Save to public path
    
            // Save the image to the public path
            if (file_put_contents($filePath, $image)) {
                $publicUrl = 'images/users/' . $imageName;
                return $publicUrl;
            } else {
                Log::error('Failed to store the image.', ['filePath' => $filePath]);
                return response()->json(['status' => 500, 'message' => 'Failed to store the image'], 500);
            }
        }
    
        return response()->json(['status' => 400, 'message' => 'No image provided'], 400);

        // if ($request->has('image')) {
        //     $image = $request->image;  // your base64 encoded image

        //     if (strpos($image, 'data:image/png;base64,') === 0) {
        //         $image = str_replace('data:image/png;base64,', '', $image);
        //     }
        //     $image = str_replace(' ', '+', $image);
        //     $imageName = Str::random(10) . '.png';
        //     $relativeFilePath = 'images/' . $folderName . '/' . $imageName;
        //     $fullPath = public_path($relativeFilePath);

        //     $decodedImage = base64_decode($image);
        //     if ($decodedImage === false) {
        //         return response()->json(['error' => 'Base64 decode failed'], 400);
        //     }

        //     if (!File::put($fullPath, $decodedImage)) {
        //         return response()->json(['error' => 'File save failed'], 500);
        //     }
        //     return $relativeFilePath;
        // }

        // return null;
    }


    public function multipleImage($image, $imageName, $folderName)
    {
        if ($image->isValid()) { // Check if the image is valid
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/' . $folderName), $imageName);
            return $folderName . '/' . $imageName;
        }
        return null;
    }

}