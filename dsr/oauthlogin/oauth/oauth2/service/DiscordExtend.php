<?php
/**
 *
 * Extend OAuth login. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023, DSR! https://github.com/xchwarze
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace OAuth\OAuth2\Service;

use OAuth\OAuth2\Token\StdOAuth2Token;
use OAuth\Common\Http\Exception\TokenResponseException;
use OAuth\Common\Http\Uri\Uri;
use OAuth\Common\Consumer\CredentialsInterface;
use OAuth\Common\Http\Client\ClientInterface;
use OAuth\Common\Storage\TokenStorageInterface;
use OAuth\Common\Http\Uri\UriInterface;

class DiscordExtend extends AbstractService
{
    /**
     * Scope list
     * @see https://discord.com/developers/docs/topics/oauth2#shared-resources-oauth2-scopes
     */
    const SCOPE_IDENTIFY = 'identify';

    public function __construct(
        CredentialsInterface  $credentials,
        ClientInterface       $httpClient,
        TokenStorageInterface $storage,
                              $scopes = array(),
        UriInterface          $baseApiUri = null
    ) {
        parent::__construct($credentials, $httpClient, $storage, $scopes, $baseApiUri, true);

        if (null === $baseApiUri) {
            $this->baseApiUri = new Uri('https://discordapp.com/api/v6/');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function service()
    {
        return 'Discord';
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorizationEndpoint()
    {
        return new Uri('https://discordapp.com/api/v6/oauth2/authorize');
    }

    /**
     * {@inheritdoc}
     */
    public function getAccessTokenEndpoint()
    {
        return new Uri('https://discordapp.com/api/v6/oauth2/token');
    }

    /**
     * {@inheritdoc}
     */
    protected function getAuthorizationMethod()
    {
        return static::AUTHORIZATION_METHOD_HEADER_BEARER;
    }

    /**
     * {@inheritdoc}
     */
    protected function parseAccessTokenResponse($responseBody)
    {
        // all logic from: src/OAuth/OAuth2/Service/DeviantArt.php
        $data = json_decode($responseBody, true);

        if (null === $data || !is_array($data)) {
            throw new TokenResponseException('Unable to parse response.');
        } elseif (isset($data['error'])) {
            throw new TokenResponseException('Error in retrieving token: "' . $data['error'] . '"');
        }

        $token = new StdOAuth2Token();
        $token->setAccessToken($data['access_token']);
        unset($data['access_token']);

        if (isset($data['expires_in'])) {
            $token->setLifeTime($data['expires_in']);
            unset($data['expires_in']);
        }

        if (isset($data['refresh_token'])) {
            $token->setRefreshToken($data['refresh_token']);
            unset($data['refresh_token']);
        }

        $token->setExtraParams($data);

        return $token;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorizationUri(array $additionalParameters = [])
    {
        /**
         * Notes about "prompt" parameter
         * @see https://discord.com/developers/docs/topics/oauth2#authorization-code-grant
         */
        $additionalParameters['prompt'] = 'none';

        return parent::getAuthorizationUri($additionalParameters);
    }
}
