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
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Request;

final class GithubConnector extends Connector
{
    use AcceptsJson;

    public ?int $tries = 3;
    public ?int $retryInterval = 100;

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

        return $this->refreshToken();
    }

    /**
     * Handle out-of-date token errors and refresh it on the fly
     */
    public function handleRetry(FatalRequestException|RequestException $exception, Request $request): bool
    {
        // Handle only out-of-date token errors
        if (! $exception instanceof RequestException) return false;
        if ($exception->getStatus() !== 401) return false;

        $this->refreshToken();

        return true;
    }

    /**
     * Refresh the token for the connector and update the authenticator in the cache
     */
    private function refreshToken(): TokenAuthenticator {
        $installationAccessToken = $this->generateInstallationAccessToken();
        $tokenAuthenticator      = new TokenAuthenticator($installationAccessToken->value);

        Cache::put('github.token-authenticator', $tokenAuthenticator, $installationAccessToken->expires_at);

        $this->authenticate($tokenAuthenticator);

        return $tokenAuthenticator;
    }

    private function generateInstallationAccessToken(): GithubInstallationAccessTokenData
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
