<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use function Pest\Faker\faker;
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

    expect($user)->name->toBe($showUser['attributes']['name']);
    expect($user)->nickname->toBe($showUser['attributes']['nickname']);
});