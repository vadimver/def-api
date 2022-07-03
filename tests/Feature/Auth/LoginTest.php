<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use function Pest\Laravel\postJson;

// Success
it('should login a user', function () {
    $user = User::factory()->create();

    $user = postJson('api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
        ->assertStatus(Response::HTTP_OK)
        ->json('data');
});

// Fail
it('should return 422 if data does not have password', function () {
    $user = User::factory()->create();

    $user = postJson('api/login', [
        'email' => $user->email,
    ])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->json('data');
});

it('should return 401 if request have incorrect data', function () {
    $user = User::factory()->create();

    $user = postJson('api/login', [
        'email' => $user->email,
        'password' => 'wrong_password',
    ])
        ->assertStatus(Response::HTTP_UNAUTHORIZED)
        ->json('data');
});
