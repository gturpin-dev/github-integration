<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;
use Firebase\JWT\JWT;

class GithubJWTData extends Data
{
    public function __construct(
        public readonly string $token,
    ) {}

    public static function from_credentials(
        string $clientId,
        string $privateKey,
    ): static {
        return new static(
            token: JWT::encode(
                payload: [
                    'iat' => time() - 60,
                    'exp' => time() + (10 * 60),
                    'iss' => $clientId,
                    'alg' => 'RS256',
                ],
                key: $privateKey,
                alg: 'RS256'
            )
        );
    }
}
