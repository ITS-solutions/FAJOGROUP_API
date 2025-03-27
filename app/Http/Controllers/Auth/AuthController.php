<?php

namespace App\Http\Controllers\Auth;

use App\Facades\ApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;

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
            return ApiResponse::error('Unauthorized', 401);
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
        return ApiResponse::success(Auth::user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::success('Logged out successfully');
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
        $user = User::find(Auth::id());
        $permissions = [];
        
        // check if rol admin, return all permissions
        if($user->hasRole('admin')) {
            $permissions = Permission::all()->pluck('name')->toArray();
        } else {
            $permissions = Auth::user()->getAllPermissions()->pluck('name')->toArray();
        }

        // if permissions is emprty, return unauthorized
        if (empty($permissions)) {
            return ApiResponse::error('Unauthorized', 401);
        }

        $user['permissions'] = $permissions;
        
        return ApiResponse::success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => $user,
        ]);
    }
}
