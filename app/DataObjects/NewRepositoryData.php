<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapName;

final class NewRepositoryData extends Data
{
    public function __construct(
        public readonly string $name,

        public readonly string $description,

        #[MapName('is_private')]
        public readonly bool $isPrivate,
    ) {}
}
