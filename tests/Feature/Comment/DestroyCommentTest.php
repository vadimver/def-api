<?php

namespace Tests\Feature\Comment;

use App\Models\Comment;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use function Pest\Laravel\deleteJson;
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

it('should destroy a comment', function () {
    $comment = Comment::factory()->create();

    deleteJson(route('comments.destroy', $comment->uuid))
        ->assertStatus(Response::HTTP_NO_CONTENT);
});

it('should return 404 if Comment does not have correct uuid', function () {
    $comment = Comment::factory()->create();

    $wrongUuid = $comment->uuid. 1;

    deleteJson(route('comments.destroy', $wrongUuid))
        ->assertStatus(Response::HTTP_NOT_FOUND);
});
