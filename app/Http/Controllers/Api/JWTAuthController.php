<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthController extends Controller
{
    //
    public function login(Request $request)
    {
        // Validate the request
        $credentials = $request->only('email', 'password');

        $loginType = $request->get('login_type', 'api');

        if (!$token = auth($loginType)->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'token' => $token,
        ]);
    }

    public function me()
    {
        $token = JWTAuth::getToken();
        $payload = JWTAuth::setToken($token)->getPayload();
        $userType = $payload->get('user_type');
        $guard = $userType === 'user' ? 'api' : 'customer';
        $user = auth()->guard($guard)->user();

        return response()->json([
            'email' => $user->email,
            'name' => $user->name,
            'user_type' => $userType,
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return response()->json([
            'token' => JWTAuth::refresh()
        ]);
    }
}
