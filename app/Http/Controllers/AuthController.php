<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identification' => ['required'],
            'password' => ['required'],
        ]);
 
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
                'data' => null
            ], 401);
        }

        $token = $request->user()->createToken(str()->random(40))->plainTextToken;

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json([
            'status' => 'ok',
            'message' => null,
            'data' => [
                'user' => Auth::user()
            ]
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function respondWithToken($token)
    {
        return response()->json([
            'status' => 'ok',
            'message' => null,
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => Auth::user()
            ]
        ]);
    }
}
