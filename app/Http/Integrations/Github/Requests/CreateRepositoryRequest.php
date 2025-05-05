<?php

namespace App\Http\Integrations\Github\Requests;

use App\DataObjects\NewRepositoryData;
use App\DataObjects\RepositoryData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateRepositoryRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::POST;

    public function __construct(
        private readonly NewRepositoryData $newRepositoryData,
    ) {}

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/user/repos';
    }

    protected function defaultBody(): array
    {
        return [
            'name'        => $this->newRepositoryData->name,
            'description' => $this->newRepositoryData->description,
            'private'     => $this->newRepositoryData->isPrivate,
        ];
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return RepositoryData::from(
            $response->json()
        );
    }
}
