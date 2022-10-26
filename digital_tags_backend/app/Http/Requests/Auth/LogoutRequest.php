<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LogoutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ids' => 'array|nullable',
            'ids.*' => 'distinct|integer'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
