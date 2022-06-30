<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ImageUploader;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(protected User $user)
    {
    }

    public function register(RegisterRequest $request, ImageUploader $imageUploader): JsonResponse
    {
        $avatarPath = $imageUploader->upload($request->file('avatar'), 'avatars');
        $validatedData = array_merge($request->validated(), ['avatar' => $avatarPath]);

        $user = $this->user->create($validatedData);

        return $this->userResponse($user)
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $successAttempt = auth()->attempt($request->validated());

        if (! $successAttempt) {
            return response()->json([
                'message' => __('messages.unauthorized_login'),
                'errors' => __('messages.unauthorized'),
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->userResponse(auth()->user())
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => __('messages.logout'),
            'result' => __('messages.success'),
        ], Response::HTTP_OK);
    }

    protected function userResponse(User $user): UserResource
    {
        return new UserResource($user);
    }
}
