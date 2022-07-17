<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use function Pest\Faker\faker;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);

    $user = User::factory()->create();

    postJson('api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
        ->assertStatus(Response::HTTP_OK)
        ->json('token');
});

// Success
it('should update a post', function () {
    $post = Post::factory()->create();
    $fakeBody = faker()->text($maxNbChars = 250);

    $updatedPost = putJson('api/posts/'.$post->uuid, [
        'body' => $fakeBody,
    ])
        ->assertStatus(Response::HTTP_OK)
        ->json('data');

    expect($updatedPost)
        ->attributes->body->toBe($fakeBody);
});

// Fail
it('should return 404 if data have wrong post uuid', function () {
    $wrongUuid = faker()->uuid;
    $fakeBody = faker()->text($maxNbChars = 250);

    $post = putJson('api/posts/'.$wrongUuid, [
        'body' => $fakeBody,
    ])
        ->assertStatus(Response::HTTP_NOT_FOUND)
        ->json('data');
});
