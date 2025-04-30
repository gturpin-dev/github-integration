<?php

namespace App\DataObjects;

use App\DataObjects\Casts\CarbonInterfaceCast;
use Carbon\CarbonInterface;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

final class RepositoryData extends Data
{
    public function __construct(
        public readonly int $id,

        #[MapInputName('owner.login')]
        public readonly string $owner,
        public readonly string $name,

        #[MapInputName('full_name')]
        public readonly string $fullName,

        #[MapInputName('private')]
        public readonly bool $isPrivate,
        public readonly ?string $description,

        #[MapInputName('created_at')]
        public readonly CarbonInterface $createdAt,
    ) {}
}
