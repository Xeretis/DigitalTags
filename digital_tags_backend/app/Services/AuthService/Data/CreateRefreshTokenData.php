<?php

namespace App\Services\AuthService\Data;

use Spatie\LaravelData\Data;

class CreateRefreshTokenData extends Data
{
    public function __construct(
        public ?int $parentId = null
    ) {}
}
