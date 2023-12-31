<?php

namespace App\Containers\User\Http\Controllers;

use App\Abstractions\Controller\Controller;
use App\Containers\User\Action\RegistryUserAction;
use App\Containers\User\Http\Requests\RegisterUserRequest;
use App\Containers\User\Models\User;
use App\Containers\User\Transformers\UserTransformer;
use App\Utils\LoggerUtil;
use App\Utils\ResponseUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Fractalistic\ArraySerializer;

/**
 *
 */
class AuthController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCurrentUser(Request $request)
    {
        $user = $request->user();

        if (!$user->is_active) {
            return ResponseUtil::accessDenied();
        }

        return fractal($user)
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
            return ResponseUtil::accessDenied();
        }

        $userData = fractal($user)
            ->transformWith(new UserTransformer())
            ->serializeWith(ArraySerializer::class)
            ->toArray();

        $token = $user->createToken(
            name: 'auth_token',
            abilities: $user->role ? [$user->role] : []
        )->plainTextToken;

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

    /**
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        try {
            $userDto = $request->getUserDto();
            return (new RegistryUserAction($userDto))->handle();
        } catch (\Exception $exception) {
            LoggerUtil::exception($exception);
            return ResponseUtil::exception($exception);
        }
    }
}
