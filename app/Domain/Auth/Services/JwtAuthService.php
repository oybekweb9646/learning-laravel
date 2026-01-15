<?php

namespace App\Domain\Auth\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtAuthService
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            abort(401);
        }

        return response()->json([
            'access_token' => $token,
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function refresh(): JsonResponse
    {
        return response()->json([
            'access_token' => auth('api')->refresh(),
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function logout(): Response
    {
        auth('api')->logout(); // blacklist
        return response()->noContent();
    }
}
