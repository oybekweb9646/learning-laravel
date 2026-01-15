<?php

namespace App\Http\Controllers\Api;

use App\Domain\Auth\Services\JwtAuthService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class AuthController extends Controller
{
    public function __construct(
        private readonly JwtAuthService $jwtAuthService
    )
    {
    }

    /**
     * LOGIN → access token olish
     */
    public function login(Request $request)
    {
        return $this->jwtAuthService->login($request);
    }

    /**
     * REFRESH → eskirgan tokenni yangilash (BAZASIZ)
     */
    public function refresh()
    {
        return $this->jwtAuthService->refresh();
    }

    /**
     * ME → token orqali user olish
     */
    public function me(Request $request)
    {
        return request()->user();
    }

    /**
     * LOGOUT → tokenni blacklist qilish
     */
    public function logout()
    {
        return $this->jwtAuthService->logout();
    }

    /**
     * Token response helper
     */
    private function respondWithToken(string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
