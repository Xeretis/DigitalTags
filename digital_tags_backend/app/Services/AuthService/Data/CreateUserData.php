<?php

namespace App\Services\AuthService\Data;

use Spatie\LaravelData\Data;

class CreateUserData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}
}
