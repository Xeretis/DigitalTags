<?php

namespace App\Services\AuthService\Actions;

use App\Jobs\Auth\DeleteTokensFromCacheJob;
use App\Services\AuthService\Data\DeleteSessionData;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteSessionAction
{
    use AsAction;

    public function handle(DeleteSessionData $data): void {
        if ($data->ids !== null) {
            if (in_array(request()->user()->currentAccessToken()->id, $data->ids)) {
                [, $token] = explode(' ', request()->header('Authorization'));
                Cache::delete("PersonalAccessToken::$token");
            }

            //Tokens still remain in cache for at most 10 minutes
            request()->user()->tokens()->whereIn('id', $data->ids)->delete();
        } else {
            request()->user()->currentAccessToken()->delete();

            [, $token] = explode(' ', request()->header('Authorization'));
            Cache::delete("PersonalAccessToken::$token");
        }
    }
}
