<?php

namespace App\Helpers\Auth\Traits;

use App\Helpers\Auth\NewRefreshToken;
use App\Models\RefreshToken;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

trait HasRefreshTokens
{
    public function refreshTokens(): MorphMany
    {
        return $this->morphMany(RefreshToken::class, 'tokenable');
    }

    public function createRefreshToken(string $name, ?int $parentId = null, array $abilities = ['*'], \DateTimeInterface $expiresAt = null): NewRefreshToken
    {
        $token = $this->refreshTokens()->create([
            'parent_id' => $parentId,
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
            'expires_at' => $expiresAt,
        ]);

        return new NewRefreshToken($token, $token->getKey().'|'.$plainTextToken);
    }
}
