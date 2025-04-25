<?php

declare(strict_types=1);

namespace App\Http\Integrations\Github\Paginations;

use Saloon\Http\Response;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\PagedPaginator;

final class GithubPagedPaginator extends PagedPaginator
{
    protected ?int $perPageLimit = 20;

    protected function isLastPage(Response $response): bool {
        $links       = $response->header('Link');
        $nextPattern = '/(?<=<)([\S]*)(?=>; rel="Next")/i';

        if (preg_match($nextPattern, $links)) {
            return false;
        }

        return true;
    }

    protected function getPageItems(Response $response, Request $request): array {
        return $response->dtoOrFail();
    }
}
