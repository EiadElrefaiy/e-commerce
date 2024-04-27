<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
    // Extract email and password from the request
    $credentials = $request->only('phone', 'password');

    // Attempt to generate a JWT token using the provided credentials
    if (!$token = JWTAuth::attempt($credentials)) {
        // If authentication fails, return an error response
        return response()->json(['error' => 'Invalid phone or password'], 401);
    }

    // Retrieve the authenticated user
    $user = Auth::user();

    // If authentication is successful, return the JWT token and user details
    return response()->json(['token' => $token, 'user' => $user], 200);
    }
}
