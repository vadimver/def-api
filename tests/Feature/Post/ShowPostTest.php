<?php

namespace Tests\Feature\User;

use App\Models\Post;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Http\Response;
use function Pest\Laravel\getJson;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

// Success
it('should show a post', function () {
    $post = Post::factory()->create();

    $showPost = getJson(route('posts.show', $post->uuid))
        ->assertStatus(Response::HTTP_OK)
        ->json('data');

    expect($showPost)
        ->attributes->title->toBe($post->title);

    expect($showPost)
        ->attributes->body->toBe($post->body);
});
