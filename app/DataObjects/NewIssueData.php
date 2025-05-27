<?php

namespace App\DataObjects;

use Spatie\LaravelData\Data;

final class NewIssueData extends Data
{
    /**
     * @param array<string> $assignees
     * @param array<string> $labels
     */
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly array $assignees = [],
        public readonly null|string|int $milestone = null,
        public readonly array $labels = [],
    ) {}
}
