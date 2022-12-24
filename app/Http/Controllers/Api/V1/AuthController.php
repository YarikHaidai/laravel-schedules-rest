<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Resources\V1\Auth\LoginResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse|LoginResource
     *
     * @group Auth
     * @apiResource App\Http\Resources\Auth\UserResource
     * @apiResourceModel App\Models\User
     */
    public function login(LoginRequest $request): JsonResponse|LoginResource
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        auth()->user()->setRememberToken($token);

        return new LoginResource(auth()->user(), $token);
    }
}
