<?php

namespace App\Http\Integrations\Github;

use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\OAuth2\AuthorizationCodeGrant;
use Saloon\Http\Connector;
use Saloon\Helpers\OAuth2\OAuthConfig;

final class GithubConnector extends Connector
{
    use AuthorizationCodeGrant;
    use AcceptsJson;

    public function __construct(
        private string $privateKey
    ) {}

    // protected function defaultAuth(): ?Authenticator
    // {
    //     return new TokenAuthenticator(
    //         token: JWT::encode(
    //             payload: [
    //                 'iat' => time() - 60,
    //                 'exp' => time() + (10 * 60),
    //                 'iss' => $this->oauthConfig()->getClientId(),
    //                 'alg' => 'RS256',
    //             ],
    //             key: $this->privateKey,
    //             alg: 'RS256'
    //         )
    //     );
    // }

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

    /**
     * The OAuth2 configuration
     */
    protected function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setClientId(config('services.github.client_id'))
            ->setClientSecret(config('services.github.client_secret'))
            ->setRedirectUri('')
            ->setDefaultScopes([])
            ->setAuthorizeEndpoint('authorize')
            ->setTokenEndpoint('token')
            ->setUserEndpoint('user');
    }
}
