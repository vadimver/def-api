<?php

namespace Tests\Feature\Comment;

use App\Models\Post;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use function Pest\Faker\faker;
use function Pest\Laravel\postJson;
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

it('should create a comment', function () {
    $postUuid = Post::all()->random()->uuid;
    $fakeBody = faker()->text($maxNbChars = 50);

    $comment = postJson('api/'.$postUuid.'/comments', [
        'body' => $fakeBody,
    ])
        ->assertStatus(Response::HTTP_CREATED)
        ->json('data');

    expect($comment)
        ->attributes->body->toBe($fakeBody);
});
