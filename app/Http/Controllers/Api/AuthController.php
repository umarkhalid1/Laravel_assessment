<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Carbon\Exceptions\Exception;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        try {
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $role = $user->role;
                $token = $user->createToken('authToken')->plainTextToken;

                return response()->json([
                    'message' => 'User login successfully',
                    'token' => $token,
                    'role' => $role
                ], 200);
            } else {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => App::environment('local') ? $e->getMessage() : 'Internal Server Error'
            ], 500);
        }
    }
}
