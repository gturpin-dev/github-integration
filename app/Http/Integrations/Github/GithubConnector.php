<?php

namespace App\Http\Integrations\Github;

use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\OAuth2\AuthorizationCodeGrant;
use Saloon\Http\Connector;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Contracts\Authenticator;
use Illuminate\Support\Facades\Cache;
use App\Http\Integrations\Github\Requests\GenerateInstallationAccessTokenRequest;
use App\DataObjects\GithubJWTData;
use App\DataObjects\GithubInstallationAccessTokenData;

final class GithubConnector extends Connector
{
    use AcceptsJson;

    public function __construct(
        private readonly string $installationId,
        private readonly string $clientId,
        private readonly string $privateKey
    ) {}

    protected function defaultAuth(): ?Authenticator
    {
        $authenticator = Cache::get('github.token-authenticator');

        if ($authenticator instanceof TokenAuthenticator) {
            return $authenticator;
        }

        $installationAccessToken = $this->generateInstallationAccessToken();
        $tokenAuthenticator      = new TokenAuthenticator($installationAccessToken->value);

        Cache::put('github.token-authenticator', $tokenAuthenticator, $installationAccessToken->expires_at);

        return $tokenAuthenticator;
    }

    protected function generateInstallationAccessToken(): GithubInstallationAccessTokenData
    {
        return $this->send(new GenerateInstallationAccessTokenRequest(
            installationId: $this->installationId,
            jwt           : GithubJWTData::from_credentials(
                clientId  : $this->clientId,
                privateKey: $this->privateKey,
            )
        ))->dtoOrFail();
    }

    /**
     * The Base URL of the API.
     */
    public function resolveBaseUrl(): string
    {
        return 'https://api.github.com/';
    }

    public function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/vnd.github+json',
        ];
    }
}
