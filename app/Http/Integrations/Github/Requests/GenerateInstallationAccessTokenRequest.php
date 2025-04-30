<?php

namespace App\Http\Integrations\Github\Requests;

use Saloon\Http\Response;
use Saloon\Http\Request;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Enums\Method;
use Saloon\Contracts\Authenticator;
use App\DataObjects\GithubJWTData;
use App\DataObjects\GithubInstallationAccessTokenData;

final class GenerateInstallationAccessTokenRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::POST;

    public function __construct(
        private string $installationId,
        private GithubJWTData $jwt,
    ) {}

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return sprintf( 'app/installations/%s/access_tokens', $this->installationId );
    }

    protected function defaultAuth(): ?Authenticator
    {
        return new TokenAuthenticator(
            token: $this->jwt->token
        );
    }

    public function createDtoFromResponse(Response $response): GithubInstallationAccessTokenData
    {
        return GithubInstallationAccessTokenData::from($response->json());
    }
}
