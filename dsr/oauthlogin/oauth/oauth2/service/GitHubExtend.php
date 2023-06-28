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

use OAuth\Common\Consumer\CredentialsInterface;
use OAuth\Common\Http\Client\ClientInterface;
use OAuth\Common\Http\Uri\UriInterface;
use OAuth\Common\Storage\TokenStorageInterface;

class GitHubExtend extends GitHub
{
    public function __construct(
        CredentialsInterface  $credentials,
        ClientInterface       $httpClient,
        TokenStorageInterface $storage,
                              $scopes = array(),
        UriInterface          $baseApiUri = null
    )
    {
        parent::__construct($credentials, $httpClient, $storage, $scopes, $baseApiUri);
        $this->stateParameterInAuthUrl = true;
    }

    /**
     * {@inheritdoc}
     */
    public function service()
    {
        return 'GitHub';
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
    protected function getExtraApiHeaders()
    {
        return array('Accept' => 'application/vnd.github.v3+json');
    }
}
