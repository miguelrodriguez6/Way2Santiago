<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'verify', 'logout']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            Log::info('This is an info log');

            $token = $request->cookie('jwt');

            if ($token) {
                auth()->setToken($token)->invalidate(); // invalida el JWT
            }

            // borrar cookie
            $cookie = cookie('jwt', '', -1, '/', 'localhost', false, false, false, 'Lax');

            return response()->json(['message' => 'Successfully logged out'])
                ->cookie($cookie);

        } catch (\Exception $e) {
            Log::error('Logout error: '.$e->getMessage());

            return response()->json(['error' => 'Could not log out'], 500)->cookie($cookie);
        }
    }


    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Verify if the user is authenticated.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $token = $request->cookie('jwt');
            Log::info('Token received:', ['token' => $token]);

            if (!$token) {
                return response()->json([
                    'isAuthenticated' => false,
                    'message' => 'No token provided'
                ], 401);
            }

            auth()->setToken($token)->checkOrFail();

            return response()->json([
                'isAuthenticated' => true,
                'user' => auth()->user()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'isAuthenticated' => false,
                'message' => 'Invalid or expired token'
            ], 401);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = auth()->user();

        $cookie = cookie('jwt', $token, auth()->factory()->getTTL() * 60, '/', 'localhost', false, false, false, 'Lax');

        return response()->json([
            'message' => 'Login successful',
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $user
        ])->cookie($cookie);
    }
}
