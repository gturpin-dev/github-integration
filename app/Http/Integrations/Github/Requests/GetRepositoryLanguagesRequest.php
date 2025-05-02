<?php

namespace App\Http\Integrations\Github\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetRepositoryLanguagesRequest extends Request
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
        return sprintf(
            '/repos/%s/%s/languages',
            $this->owner,
            $this->repositoryName
        );
    }
}
