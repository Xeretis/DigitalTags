<?php

namespace App\Services\AuthService\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class CreateSessionAction
{
    use AsAction;

    public function handle(): ?string {
        return auth()->user()->createToken('Api Token - ' . request()->userAgent())->plainTextToken;
    }
}
