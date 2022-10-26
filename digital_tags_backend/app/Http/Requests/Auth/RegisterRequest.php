<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:256',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|string|min:8'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
