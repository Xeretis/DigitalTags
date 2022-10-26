<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'nullable|boolean'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
