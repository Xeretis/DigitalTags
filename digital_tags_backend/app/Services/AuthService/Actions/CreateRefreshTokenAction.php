<?php

namespace App\Services\AuthService\Actions;

use App\Services\AuthService\Data\CreateRefreshTokenData;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateRefreshTokenAction
{
    use AsAction;

    public function handle(CreateRefreshTokenData $data): string {
        return auth()->user()->createRefreshToken('Refresh Token - ' . request()->userAgent(), $data->parentId)->plainTextToken;
    }
}
