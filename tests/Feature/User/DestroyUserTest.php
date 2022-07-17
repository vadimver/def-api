<?php

namespace Tests\Feature\User;

use App\Models\User;
use function Pest\Faker\faker;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;
use Symfony\Component\HttpFoundation\Response;

// Success
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

// Fail
it('should return 404 if User does not have correct uuid', function () {
    $user = User::factory()->create();

    postJson('api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
        ->assertStatus(Response::HTTP_OK)
        ->json('token');

    $wrongUuid = faker()->uuid;

    deleteJson(route('users.destroy', $wrongUuid))
        ->assertStatus(Response::HTTP_NOT_FOUND);
});
