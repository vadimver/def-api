<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

// Success
it('should update a user name', function () {
    $user = User::factory()->create();

    postJson('api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
        ->assertStatus(Response::HTTP_OK)
        ->json('token');

    $name = 'Test name';
    $updatedUser = putJson(
        route('users.update', $user->uuid), ['name' => $name])
            ->assertStatus(Response::HTTP_OK)
            ->json('data');

    expect($updatedUser)
        ->attributes->name->toBeString();
});
