<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ImageUploader;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function show(User $user): JsonResponse
    {
        return $this->userResponse($user)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function update(UpdateRequest $request, User $user, ImageUploader $imageUploader): JsonResponse
    {
        $avatarPath = $imageUploader->upload($request->file('avatar'), 'avatars');
        $validatedData = array_merge($request->validated(), ['avatar' => $avatarPath]);
        $user->update($validatedData);

        return $this->userResponse($user)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(User $user): Response
    {
        $a = $user->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }

    protected function userResponse(User $user): UserResource
    {
        return new UserResource($user);
    }
}
