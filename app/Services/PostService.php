<?php

namespace App\Services;

final class PostService
{
    public function __construct(protected  ImageUploader $imageUploader)
    {
    }

    public function storeData($request): array
    {
        $imagePath = $this->imageUploader->upload($request->file('main_image'));
        $additionalData = [
            'user_id' => auth()->id(),
            'main_image' => $imagePath,
        ];

        return array_merge($request->validated(), $additionalData);
    }

    public function updateData($request): array
    {
        $additionalData = [];
        if ($request->file('main_image') !== null) {
            $imagePath = $this->imageUploader->upload($request->file('main_image'));
            $additionalData = [
                'main_image' => $imagePath,
            ];
        }

        return array_merge($request->validated(), $additionalData);
    }
}
