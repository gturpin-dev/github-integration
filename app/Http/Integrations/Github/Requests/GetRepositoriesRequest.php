<?php

namespace App\Http\Integrations\Github\Requests;

use Saloon\PaginationPlugin\Contracts\Paginatable;
use Saloon\Http\Response;
use Saloon\Http\Request;
use Saloon\Enums\Method;
use App\DataObjects\RepositoryData;
use App\Http\Integrations\Github\Paginations\GithubPagedPaginator;
use Saloon\Http\Connector;
use Saloon\PaginationPlugin\Contracts\HasRequestPagination;
use Saloon\PaginationPlugin\Paginator;

class GetRepositoriesRequest extends Request implements Paginatable, HasRequestPagination
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(
        private string $owner,
    ) {}

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return sprintf('/users/%s/repos', $this->owner);
    }

    public function paginate(Connector $connector): Paginator {
        return new GithubPagedPaginator($connector, $this);
    }

    public function createDtoFromResponse(Response $response): array
    {
        return array_map(
            fn (array $repositoryData) => RepositoryData::from($repositoryData),
            $response->json()
        );
    }
}
