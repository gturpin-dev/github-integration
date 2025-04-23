<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;

final class UpdateRepositoryData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly bool $isPrivate,
    ) {}
}
