<?php

namespace App\DataObjects;

use Carbon\CarbonInterface;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class GithubInstallationAccessTokenData extends Data
{
    public function __construct(
        #[MapInputName('token')]
        public readonly string $value,
        public readonly CarbonInterface $expires_at,
    ) {}
}
