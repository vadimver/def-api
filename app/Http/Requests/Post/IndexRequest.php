<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'sometimes|integer',
            'tag_id' => 'sometimes|array',
        ];
    }
}
