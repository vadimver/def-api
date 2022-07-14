<?php

namespace Tests\Feature\User;

use App\Models\User;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;
use Symfony\Component\HttpFoundation\Response;

it('should destroy a user', function () {
    $user = User::factory()->create();

    postJson('api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
        ->assertStatus(Response::HTTP_OK)
        ->json('token');

    deleteJson(route('users.destroy', $user->uuid))
        ->assertStatus(Response::HTTP_NO_CONTENT);
});

it('should return 404 if User does not have correct uuid', function () {
    $user = User::factory()->create();

    postJson('api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
        ->assertStatus(Response::HTTP_OK)
        ->json('token');

    $wrongUuid = $user->uuid.'1';

    deleteJson(route('users.destroy', $wrongUuid))
        ->assertStatus(Response::HTTP_NOT_FOUND);
});
