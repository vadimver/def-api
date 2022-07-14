<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'sometimes|exists:categories,id',
            'tagIds.*' => 'sometimes|exists:tags,id',
            'title' => 'sometimes|string|max:255',
            'excerpt' => 'sometimes|string',
            'body' => 'sometimes|string',
            'main_image' => 'sometimes|image',
        ];
    }
}
