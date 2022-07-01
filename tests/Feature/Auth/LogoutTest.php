<?php

use App\Models\User;
use Illuminate\Http\Response;
use function Pest\Laravel\postJson;

// Success
it('should logout a user', function () {
    $user = User::factory()->create();

    $token = postJson('api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
        ->assertStatus(Response::HTTP_OK)
        ->json('token');

    $result = postJson('api/logout')
        ->assertStatus(Response::HTTP_OK);
});
