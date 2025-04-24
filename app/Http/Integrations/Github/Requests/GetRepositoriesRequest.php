<?php

namespace App\Http\Integrations\Github\Requests;

use App\Collections\Github\RepositoryCollection;
use App\DataObjects\RepositoryData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetRepositoriesRequest extends Request
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

    public function createDtoFromResponse(Response $response): RepositoryCollection
    {
        return (new RepositoryCollection($response->json()))->map(fn (array $repositoryData) => RepositoryData::from($repositoryData));
    }
}
