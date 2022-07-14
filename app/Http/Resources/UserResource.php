<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
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
                'name' => $this->name,
                'nickname' => $this->nickname,
                'avatar' => $this->avatar,
                'email' => $this->email,
            ],
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request): array
    {
        return [
            'token' => $this->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer',
            'result' => __('messages.success'),
        ];
    }
}
