<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function __construct(protected Comment $comment)
    {
    }

    public function store(Post $post, StoreRequest $request): Response
    {
        $comment = $post->comments()->create(['body' => $request->body, 'user_id' => auth()->id()]);

        return response([
            'data' => new CommentResource($comment),
        ], Response::HTTP_CREATED);
    }

    public function destroy(Comment $comment): Response
    {
        $comment->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }
}
