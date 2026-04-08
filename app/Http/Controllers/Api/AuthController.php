<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register a new user.
     * POST /api/auth/register
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'user',
        ]);

        $token = auth('api')->login($user);

        return $this->respondWithToken($token, $user, 201);
    }

    /**
     * Authenticate user and return JWT token.
     * POST /api/auth/login
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials.',
            ], 401);
        }

        return $this->respondWithToken($token, auth('api')->user());
    }

    /**
     * Get authenticated user profile.
     * GET /api/auth/me
     */
    public function me(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => auth('api')->user(),
        ]);
    }

    /**
     * Refresh JWT token.
     * POST /api/auth/refresh
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth('api')->refresh(), auth('api')->user());
    }

    /**
     * Logout (invalidate token).
     * POST /api/auth/logout
     */
    public function logout(): JsonResponse
    {
        auth('api')->logout();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out.',
        ]);
    }

    // ── Private helpers ──

    private function respondWithToken(string $token, User $user, int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => [
                'user'         => $user,
                'access_token' => $token,
                'token_type'   => 'Bearer',
                'expires_in'   => config('jwt.ttl') * 60,
            ],
        ], $status);
    }
}
