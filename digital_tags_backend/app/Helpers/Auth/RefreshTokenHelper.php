<?php

namespace App\Helpers\Auth;

use App\Models\RefreshToken;

class RefreshTokenHelper
{
    public static function findToken($token): RefreshToken|null
    {
        if (!str_contains($token, '|')) {
            return RefreshToken::where('token', hash('sha256', $token))->first();
        }

        [$id, $token] = explode('|', $token, 2);

        $instance = RefreshToken::find($id);

        if ($instance) {
            return hash_equals($instance->token, hash('sha256', $token)) ? $instance : null;
        }

        return null;
    }

}
