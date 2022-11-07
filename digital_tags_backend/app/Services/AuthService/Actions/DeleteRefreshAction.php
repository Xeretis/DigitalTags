<?php

namespace App\Services\AuthService\Actions;

use App\Helpers\Auth\RefreshTokenHelper;
use App\Services\AuthService\Data\DeleteRefreshData;
use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteRefreshAction
{
    use AsAction;

    public function handle(DeleteRefreshData $data): void {
        if ($data->ids !== null) {
            request()->user()->refreshTokens()->whereIn('id', $data->ids)->delete();
        } else {
            $refreshToken = request()->cookie('refresh_token'); //TODO: null
            RefreshTokenHelper::findToken($refreshToken)->delete();
        }
    }

}
