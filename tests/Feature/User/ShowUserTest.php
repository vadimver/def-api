<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Http\Response;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

// Success
it('should show a user name and nickname', function () {
    $user = User::factory()->create();

    postJson('api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
        ->assertStatus(Response::HTTP_OK);

    $showUser = getJson(route('users.show', $user->uuid))
        ->assertStatus(Response::HTTP_OK)
        ->json('data');

    expect($showUser)
        ->attributes->name->toBe($user->name);

    expect($showUser)
        ->attributes->nickname->toBe($user->nickname);
});
