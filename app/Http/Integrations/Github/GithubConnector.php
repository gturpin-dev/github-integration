<?php

namespace App\Http\Integrations\Github;

use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\OAuth2\AuthorizationCodeGrant;
use Saloon\Http\Connector;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Contracts\Authenticator;

class GithubConnector extends Connector
{
    use AuthorizationCodeGrant;
    use AcceptsJson;

    public function __construct(
        private ?string $token = null,
    ) {
        $this->token ??= config('services.github.token');
    }

    protected function defaultAuth(): ?Authenticator
    {
        return new TokenAuthenticator($this->token);
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
            'Accept' => 'application/vnd.github.v3+json',
        ];
    }

    /**
     * The OAuth2 configuration
     */
    protected function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setClientId('')
            ->setClientSecret('')
            ->setRedirectUri('')
            ->setDefaultScopes([])
            ->setAuthorizeEndpoint('authorize')
            ->setTokenEndpoint('token')
            ->setUserEndpoint('user');
    }
}
