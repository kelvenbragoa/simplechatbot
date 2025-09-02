<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Service\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
        public function __construct(private readonly AuthService $authService)
    {
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|string',
                'password' => 'required|min:8'
            ]);
            return $this->authService->login($credentials);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erro ao realizar login: ' . $th->getMessage()
            ], 500);
        }
        
    }
}
