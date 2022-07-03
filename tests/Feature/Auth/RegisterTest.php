<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use function Pest\Faker\faker;
use function Pest\Laravel\postJson;

// Success
it('should register a user without avatar', function () {
    $password = faker()->password;

    $user = postJson('api/register', [
        'name' => faker()->name,
        'nickname' => faker()->userName,
        'email' => faker()->email,
        'password' => $password,
        'password_confirmation' => $password,
    ])
        ->assertStatus(Response::HTTP_CREATED)
        ->json('data');
});

it('should register a user with avatar', function () {
    $password = faker()->password;

    $user = postJson('api/register', [
        'name' => faker()->name,
        'nickname' => faker()->userName,
        'avatar' => UploadedFile::fake()->image('photo1.jpg'),
        'email' => faker()->email,
        'password' => $password,
        'password_confirmation' => $password,
    ])
        ->assertStatus(Response::HTTP_CREATED)
        ->json('data');
});

it('should include UUID', function () {
    $user = User::factory()->create();

    expect($user)->uuid->toBeString();
});

// Fail
it('should return 422 if data does not have nickname', function () {
    $password = faker()->password;

    $user = postJson('api/register', [
        'name' => faker()->name,
        'email' => faker()->email,
        'password' => $password,
        'password_confirmation' => $password,
    ])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('should return 422 if avatar is not image', function () {
    $password = faker()->password;

    $user = postJson('api/register', [
        'name' => faker()->name,
        'email' => faker()->email,
        'avatar' => 'fake image',
        'password' => $password,
        'password_confirmation' => $password,
    ])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('should return 422 if nickname is not unique', function () {
    $user = User::factory()->create();
    $password = faker()->password;

    $user = postJson('api/register', [
        'name' => faker()->name,
        'nickname' => $user->userName,
        'email' => faker()->email,
        'password' => $password,
        'password_confirmation' => $password,
    ])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('should return 422 if email is not unique', function () {
    $user = User::factory()->create();
    $password = faker()->password;

    $user = postJson('api/register', [
        'name' => faker()->name,
        'nickname' => $user->userName,
        'email' => faker()->email,
        'password' => $password,
        'password_confirmation' => $password,
    ])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});
