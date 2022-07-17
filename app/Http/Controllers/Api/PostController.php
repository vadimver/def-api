<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\IndexRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function __construct(protected Post $post, protected PostService $postService)
    {
    }

    public function index(IndexRequest $request): PostCollection
    {
        $collection = $this->post->filter($request->all())->get();

        return new PostCollection($collection);
    }

    public function store(StoreRequest $request): Response
    {
        $verifiedData = $this->postService->storeData($request);
        $post = $this->post->create($verifiedData);
        $post->tags()->sync($request->tagIds ?? []);

        return response([
            'data' => new PostResource($post),
        ], Response::HTTP_CREATED);
    }

    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }

    public function update(UpdateRequest $request, Post $post): PostResource
    {
        $verifiedData = $this->postService->updateData($request);
        $post->update($verifiedData);
        $post->tags()->sync($request->tagIds ?? []);

        return new PostResource($post);
    }

    public function destroy(Post $post): Response
    {
        $post->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }
}
