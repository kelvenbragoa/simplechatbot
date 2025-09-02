<?php

namespace App\Service\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Create a new class instance.
     */

    public function __construct()
    {
        
    }
    public function login($credentials): JsonResponse
    {
         $user = User::where('email', strtolower($credentials['email']))->first();
         $userId = $user->id ?? null;

         if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = $user->createToken($user->email . '-AuthToken')->plainTextToken;

            return response()->json([
                'user' => $user,
                'access_token' => $token,
            ], 200);
        }

        return response()->json([
            'message' => 'Usuário ou senha incorretos'
        ], 401);
    }

    public function logout()
    {
        $user = auth()->user();
        if ($user) {
            $user->tokens()->delete();
            return response()->json(['message' => 'Logout successful'], 200);
        }
        return response()->json(['message' => 'User not authenticated'], 401);
        
    }

    public function register($userData)
    {
        
    }

    public function resetPassword($email)
    {
        
    }
}
