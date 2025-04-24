<?php

namespace App\Http\Integrations\Github\Requests;

use Saloon\Http\Response;
use Saloon\Http\Request;
use Saloon\Enums\Method;
use App\DataObjects\RepositoryData;

class GetRepositoryRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $owner,
        private readonly string $repositoryName,
    ) {}

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return sprintf( '/repos/%s/%s', $this->owner, $this->repositoryName );
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return RepositoryData::from($response->json());
    }
}
