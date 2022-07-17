<?php

namespace Tests\Feature\Post;

use App\Models\Category;
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

// Success
it('should create a post', function () {
    $categoryId = Category::all()->random()->id;
    $fakeBody = faker()->text($maxNbChars = 250);

    $post = postJson('api/posts', [
        'category_id' => $categoryId,
        'title' => faker()->text($maxNbChars = 20),
        'excerpt' => faker()->paragraph,
        'body' => $fakeBody,
        'slug' => faker()->slug,
    ])
        ->assertStatus(Response::HTTP_CREATED)
        ->json('data');

    expect($post)
        ->attributes->body->toBe($fakeBody);
});

// Fail
it('should return 422 if data have wrong category_id', function () {
    $categoryId = 'abcd';
    $fakeBody = faker()->text($maxNbChars = 250);

    $post = postJson('api/posts', [
        'category_id' => $categoryId,
        'title' => faker()->text($maxNbChars = 20),
        'excerpt' => faker()->paragraph,
        'body' => $fakeBody,
        'slug' => faker()->slug,
    ])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});
