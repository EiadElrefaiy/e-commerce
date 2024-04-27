<?php

namespace App\Http\Controllers\Admin\Section;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class GetSectionController extends Controller
{
    public function index()
    {
        // Retrieve all sections from the database
        $sections = Section::all();
        
        // Return a JSON response containing the sections
        return response()->json(['sections' => $sections]);
    }
}
