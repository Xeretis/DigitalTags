<?php

namespace App\Services\AuthService\Data;

use Spatie\LaravelData\Data;

class DeleteRefreshData extends Data
{
    public function __construct(
        public ?array $ids
    ) {}
}
