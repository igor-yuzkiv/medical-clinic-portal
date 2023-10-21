<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Transformers\UserTransformer;
use App\Utils\LoggerUtil;
use App\Utils\ResponseUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Fractalistic\ArraySerializer;
use Illuminate\Http\JsonResponse;

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

    /**
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data["password"] = \Hash::make($request->input('password'));
            $user = User::create($data);
            if ($user) {
                return ResponseUtil::success('User created successfully');
            } else {
                return ResponseUtil::error('User not created');
            }
        } catch (\Exception $exception) {
            LoggerUtil::exception($exception);
            return ResponseUtil::exception($exception);
        }
    }
}
