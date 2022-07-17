<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ImageUploader;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(protected User $user)
    {
    }

    public function register(RegisterRequest $request, ImageUploader $imageUploader): Response
    {
        $avatarPath = $imageUploader->upload($request->file('avatar'), 'avatars');
        $validatedData = array_merge($request->validated(), ['avatar' => $avatarPath]);

        $user = $this->user->create($validatedData);

        return response([
            'data' => new UserResource($user),
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request): Response
    {
        $successAttempt = auth()->attempt($request->validated());

        if (! $successAttempt) {
            return response([
                'message' => __('messages.unauthorized_login'),
                'errors' => __('messages.unauthorized'),
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response([
            'data' => new UserResource(auth()->user()),
        ], Response::HTTP_OK);
    }

    public function logout(): Response
    {
        auth()->user()->tokens()->where('id', auth()->id())->delete();

        return response([
            'message' => __('messages.logout'),
            'result' => __('messages.success'),
        ], Response::HTTP_OK);
    }
}
