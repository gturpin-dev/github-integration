<?php

declare(strict_types=1);

namespace App\Collections\Github;

use Illuminate\Support\Collection;
use App\DataObjects\RepositoryData;

/**
 * @extends Collection<int, RepositoryData>
 */
final class RepositoryCollection extends Collection {
    public function sortByCreationDate(string $sortDirection = 'DESC'): self {
        return $this->sortBy(fn (RepositoryData $repository) => $repository->createdAt, descending: $sortDirection === 'DESC');
    }
}
