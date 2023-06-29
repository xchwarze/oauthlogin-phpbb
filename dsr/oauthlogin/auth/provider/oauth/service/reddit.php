<?php
/**
 *
 * Extend OAuth login. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023, DSR! https://github.com/xchwarze
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace dsr\oauthlogin\auth\provider\oauth\service;

use OAuth\Common\Http\Exception\TokenResponseException;
use OAuth\OAuth2\Service\Reddit as RedditService;
use phpbb\auth\provider\oauth\service\base;
use phpbb\auth\provider\oauth\service\exception;
use phpbb\config\config;
use phpbb\request\request_interface;

class reddit extends base
{
    /** @var config */
    protected $config;

    /** @var request_interface */
    protected $request;

    /**
     * Constructor.
     *
     * @param config $config Config object
     * @param request_interface $request Request object
     */
    public function __construct(config $config, request_interface $request)
    {
        $this->config = $config;
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function get_auth_scope()
    {
        return [
            'identity',
            'read',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function get_service_credentials()
    {
        return [
            'key' => $this->config['auth_oauth_reddit_key'],
            'secret' => $this->config['auth_oauth_reddit_secret'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function perform_auth_login()
    {
        if (!($this->service_provider instanceof RedditService)) {
            throw new exception('AUTH_PROVIDER_OAUTH_ERROR_INVALID_SERVICE_TYPE');
        }

        try {
            // This was a callback request, get the token
            $this->service_provider->requestAccessToken($this->request->variable('code', ''));
        } catch (TokenResponseException $e) {
            throw new exception('AUTH_PROVIDER_OAUTH_ERROR_REQUEST');
        }

        try {
            // Send a request with it
            $result = (array)json_decode($this->service_provider->request('/api/v1/me'), true);
        } catch (\OAuth\Common\Exception\Exception $e) {
            throw new exception('AUTH_PROVIDER_OAUTH_ERROR_REQUEST');
        }

        // Return the unique identifier
        return $result['id'];
    }

    /**
     * {@inheritdoc}
     */
    public function perform_token_auth()
    {
        if (!($this->service_provider instanceof RedditService)) {
            throw new exception('AUTH_PROVIDER_OAUTH_ERROR_INVALID_SERVICE_TYPE');
        }

        try {
            // Send a request with it
            $result = (array)json_decode($this->service_provider->request('/api/v1/me'), true);
        } catch (\OAuth\Common\Exception\Exception $e) {
            throw new exception('AUTH_PROVIDER_OAUTH_ERROR_REQUEST');
        }

        // Return the unique identifier
        return $result['id'];
    }
}
