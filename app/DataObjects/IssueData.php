<?php

namespace App\DataObjects;

use App\Enums\IssueState;
use Carbon\CarbonInterface;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

final class IssueData extends Data
{
    /**
     * @param array<string> $labels
     * @param array<string> $assignees
     */
    public function __construct(
        public readonly int $id,
        public readonly int $number,
        public readonly IssueState $state,
        public readonly string $title,

        #[MapInputName('body')]
        public readonly string $description,

        #[MapInputName('labels.*.name')]
        public readonly array $labels = [],

        #[MapInputName('labels.*.login')]
        public readonly array $assignees = [],

        #[MapInputName('milestone.title')]
        public readonly null|int|string $milestone = null,

        #[MapInputName('created_at')]
        public readonly CarbonInterface $createdAt,

        #[MapInputName('updated_at')]
        public readonly CarbonInterface $updatedAt,
    ) {}
}
