<?php

namespace App\Http\Controllers;

use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Fractalistic\ArraySerializer;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class AuthController extends Controller
{

    public function getCurrentUser(Request $request)
    {
        return fractal($request->user())
            ->transformWith(new UserTransformer())
            ->serializeWith(ArraySerializer::class)
            ->respond();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'login'    => ['required'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'The provided credentials do not match our records'
            ], 401);
        }

        $user = Auth::user();
        if (!$user->is_active) {
            return response()->json([
                'message' => 'Access denied'
            ], 403);
        }

        $userData = fractal($user)
            ->transformWith(new UserTransformer())
            ->serializeWith(ArraySerializer::class)
            ->toArray();

        $token = $user->createToken(name: 'auth_token', abilities: [$user->role || 'default'])->plainTextToken;

        return response()->json([
            'user'  => $userData,
            'token' => $token
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        if (Auth::check()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            \Auth::user()->tokens()->delete();
        }

        return response()->json(['message' => 'Logged out successfully']);
    }
}
