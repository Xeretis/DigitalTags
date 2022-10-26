<?php

namespace App\Services\AuthService\Data;

class RefreshSessionData
{
    public function __construct(
        public string $refreshToken
    ) {}
}
