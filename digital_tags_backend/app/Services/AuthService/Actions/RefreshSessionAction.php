<?php

namespace App\Services\AuthService\Actions;

use App\Helpers\Auth\RefreshTokenHelper;
use App\Services\AuthService\Data\CreateRefreshTokenData;
use App\Services\AuthService\Data\RefreshSessionData;
use Illuminate\Support\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class RefreshSessionAction
{
    use AsAction;

    static int $refreshExpiresInDays = 30;

    public function handle(RefreshSessionData $data): ?array {
        $refreshToken = RefreshTokenHelper::findToken($data->refreshToken);

        if ($refreshToken === null) {
            return null;
        }

        if ($refreshToken->used_at || $refreshToken->created_at->diffInDays() >= self::$refreshExpiresInDays) {
            $refreshToken->delete();
            return null;
        }

        $refreshToken->used_at = Carbon::now();
        $refreshToken->save();

        $data = new CreateRefreshTokenData($refreshToken->getKey());

        $newRefreshToken = CreateRefreshTokenAction::run($data);
        $newAccessToken = CreateSessionAction::run();

        return [
            'refreshToken' => $newRefreshToken,
            'accessToken' => $newAccessToken
        ];
    }

}
