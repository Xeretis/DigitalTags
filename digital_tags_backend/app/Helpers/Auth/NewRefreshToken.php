<?php

namespace App\Helpers\Auth;

use App\Models\RefreshToken;

class NewRefreshToken
{
    public function __construct(
        public RefreshToken $refreshToken,
        public string $plainTextToken
    ) {}

    public function toArray(): array
    {
        return [
            'refreshToken' => $this->refreshToken,
            'plainTextToken' => $this->plainTextToken,
        ];
    }

    public function toJson($options = 0): bool|string
    {
        return json_encode($this->toArray(), $options);
    }
}
