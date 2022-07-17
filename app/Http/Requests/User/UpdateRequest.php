<?php

namespace App\Http\Requests\User;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'nickname' => 'string|max:255|unique:users,nickname',
            'email' => 'email|max:255|unique:users,email',
            'role' => ['nullable', new Enum(UserRole::class)],
            'avatar' => 'nullable|image',
            'password' => 'confirmed|min:8',
        ];
    }
}
