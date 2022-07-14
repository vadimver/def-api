<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public static $wrap = 'post';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->uuid,
            'attributes' => [
                'title' => $this->title,
                'excerpt' => $this->excerpt,
                'body' => $this->body,
                'slug' => $this->slug,
                'main_image' => $this->main_image,
                'published_at' => $this->published_at,
            ],
            'relationships' => [
                'author' => new UserResource($this->user),
                'category' => $this->category,
                'comments' => CommentResource::collection($this->comments),
                'tags' => $this->tags,
            ],
        ];
    }
}
