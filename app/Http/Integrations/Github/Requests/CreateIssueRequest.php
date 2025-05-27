<?php

namespace App\Http\Integrations\Github\Requests;

use App\DataObjects\IssueData;
use App\DataObjects\NewIssueData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

final class CreateIssueRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $owner,
        private readonly string $repositoryName,
        private readonly NewIssueData $data,
    ) {}

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return "/repos/$this->owner/$this->repositoryName/issues";
    }

    protected function defaultBody(): array
    {
        return [
            'title' => $this->data->title,
            'body' => $this->data->description,
            'milestone' => $this->data->milestone,
            'labels' => $this->data->labels,
            'assignees' => $this->data->assignees,
        ];
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return IssueData::from($response->json());
    }
}
