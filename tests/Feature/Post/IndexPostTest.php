<?php

namespace Tests\Feature\Post;

use App\Models\Category;
use App\Models\Tag;
use Database\Seeders\DatabaseSeeder;
use function Pest\Laravel\getJson;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

// Success
it('should show a list of posts response with tags and category', function () {
    $categoryId = Category::all()->random()->id;
    $tagId = Tag::all()->random()->id;

    getJson(route('posts.index', ['category_id' => $categoryId, 'tagIds[]' => $tagId]))
        ->assertStatus(Response::HTTP_OK);
});

it('should show a list of posts response with tags and without category', function () {
    $tagId = Tag::all()->random()->id;

    getJson(route('posts.index', ['tagIds[]' => $tagId]))
        ->assertStatus(Response::HTTP_OK);
});

it('should show a list of posts response without tags and without category', function () {
    getJson(route('posts.index'))
        ->assertStatus(Response::HTTP_OK);
});
