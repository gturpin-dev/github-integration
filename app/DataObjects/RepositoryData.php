<?php

namespace App\DataObjects;

use Carbon\CarbonInterface;
use Spatie\LaravelData\Data;

final class RepositoryData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $owner,
        public readonly string $name,
        public readonly string $fullName,
        public readonly bool $isPrivate,
        public readonly string $description,
        public readonly CarbonInterface $createdAt,
    ) {}
}
