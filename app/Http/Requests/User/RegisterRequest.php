<?php

namespace App\Http\Requests\User;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255|unique:users,nickname',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => ['nullable', new Enum(UserRole::class)],
            'avatar' => 'nullable|image',
            'password' => 'required|confirmed|min:8',
        ];
    }
}
