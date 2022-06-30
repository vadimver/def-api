<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(protected User $user)
    {
    }

    public function show(User $user)
    {
        return $this->userResponse($user)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }

    protected function userResponse(User $user): UserResource
    {
        return new UserResource($user);
    }
}
