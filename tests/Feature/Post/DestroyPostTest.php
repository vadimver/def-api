<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use function Pest\Faker\faker;
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

// Success
it('should destroy a post', function () {
    $post = Post::factory()->create();

    deleteJson(route('posts.destroy', $post->uuid))
        ->assertStatus(Response::HTTP_NO_CONTENT);
});

// Fail
it('should return 404 if Post does not have correct uuid', function () {
    $post = Post::factory()->create();

    $wrongUuid = faker()->uuid;

    deleteJson(route('posts.destroy', $wrongUuid))
        ->assertStatus(Response::HTTP_NOT_FOUND);
});
