<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|regex:/^[a-zA-Z0-9+._]*@[a-zA-Z0-9]*(\.([a-zA-Z]){2,3}){1,2}/u',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'type' => 'validation'
            ], 400);
        }

        // Find user in database
        $user = User::where('email', strtolower($request->input('email')))->first();

        if (empty($user)) {
            return response()->json([
                'message' => 'User not found',
                'type' => 'failed'
            ], 404);
        }

        // Check password
        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'message' => 'Your password isn\'t valid',
                'type' => 'failed'
            ], 400);
        }

        // Generate token
        $token = $user->createToken(config('constant.app.name'))->accessToken;

        return response()->json([
            'message' => 'Successfully logged in',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout()
    {
        Auth::user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }
}
