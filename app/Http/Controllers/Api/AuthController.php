<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! password_verify($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Check user have token
        // if ($user->tokens()->count() > 0) {
        //     return response()->json(['token' => DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->first()->token], 200);
        // }

        return response()->json(['token' => $user->createToken('api_token')->plainTextToken]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'invite_code' => 'required|string',
        ]);

        // Check if invite code is valid
        if (DB::table('invite_codes')->where('code', $request->invite_code)->where('is_used', false)->whereNull('used_at')->exists()) {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            DB::table('invite_codes')
                ->where('code', $request->invite_code)
                ->update([
                    'user_id' => $user->id,
                    'is_used' => true,
                    'used_at' => now(),
                ]);

            $user->code = $request->invite_code;
            $user->save();

            return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
        } else {
            return response()->json(['message' => 'Invalid invite code'], 422);
        }
    }
}
