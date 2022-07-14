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

    public function register(RegisterRequest $request, ImageUploader $imageUploader): UserResource
    {
        $avatarPath = $imageUploader->upload($request->file('avatar'), 'avatars');
        $validatedData = array_merge($request->validated(), ['avatar' => $avatarPath]);

        $user = $this->user->create($validatedData);

        return new UserResource($user);
    }

    public function login(LoginRequest $request): UserResource
    {
        $successAttempt = auth()->attempt($request->validated());

        if (! $successAttempt) {
            return response()->json([
                'message' => __('messages.unauthorized_login'),
                'errors' => __('messages.unauthorized'),
            ], Response::HTTP_UNAUTHORIZED);
        }

        return new UserResource(auth()->user());
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->where('id', auth()->id())->delete();

        return response()->json([
            'message' => __('messages.logout'),
            'result' => __('messages.success'),
        ], Response::HTTP_OK);
    }
}
