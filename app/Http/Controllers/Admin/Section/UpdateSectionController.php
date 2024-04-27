<?php

namespace App\Http\Controllers\Admin\Section;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;

class UpdateSectionController extends Controller
{
    public function update(Request $request)
    {
        // Find the section with the specified ID
        $section = Section::find($request->id);
    
        // Check if the section is not found
        if (!$section) {
            // If the section is not found, return a JSON response with a 404 status code and an error message
            return response()->json(['message' => 'Section not found'], 404);
        }
    
        // Validation rules
        $rules = [
            'image' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],  // image validation
            'name' => ['string'], //name must be a string
        ];
    
        // Validate the request data
        $validator = Validator::make($request->all(), $rules);
    
        // Check if validation fails
        if ($validator->fails()) {
            // If validation fails, return a JSON response with a 400 status code and the validation errors
            return response()->json(['errors' => $validator->errors()], 400);
        }
        // Update Color details
        $section->name = $request->name;

                // If image is provided, update it
                if ($request->hasFile('image')) {
                    // Generate a unique filename based on current time and file extension
                    $fileName = time() . '.' . $request->file('image')->extension();
            
                    // Store the uploaded file in the 'public/images/sections' directory with the generated filename
                    $request->file('image')->storeAs('public/images/sections', $fileName);
            
                    // Delete previous image if exists
                    if ($section->image) {
                        Storage::delete('public/'.$section->image);
                    }
            
                    // Update section's image path
                    $section->image = 'images/sections/'.$fileName;
                }
                    
        // Update the section with the incoming request data
        $section->save();
    
    
        // Return a JSON response indicating success and the updated section
        return response()->json(['message' => 'Section updated successfully', 'section' => $section]);
    }
}
