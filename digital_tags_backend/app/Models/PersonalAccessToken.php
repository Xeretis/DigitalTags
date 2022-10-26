<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;

class PersonalAccessToken extends \Laravel\Sanctum\PersonalAccessToken
{
    public static function findToken($token): PersonalAccessToken|null
    {
        $token = Cache::remember("PersonalAccessToken::$token", 600, function () use ($token) {
            return parent::findToken($token) ?? '_null_';
        });

        if ($token === '_null_') {
            return null;
        }

        return $token;
    }
}
