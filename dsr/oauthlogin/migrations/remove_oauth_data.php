<?php
/**
 *
 * Extend OAuth login. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023, DSR! https://github.com/xchwarze
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace dsr\oauthlogin\migrations;

use phpbb\db\migration\container_aware_migration;

class remove_oauth_data extends container_aware_migration
{
    /**
     * {@inheritdoc}
     */
    public function revert_data()
    {
        return [
            ['custom', [[$this, 'clean_db_tables']]],
        ];
    }

    /**
     * Remove all OAuth data from DB.
     *
     * @return void
     */
    public function clean_db_tables()
    {
        $tokens = $this->container->getParameter('tables.auth_provider_oauth_token_storage');
        $states = $this->container->getParameter('tables.auth_provider_oauth_states');
        $accounts = $this->container->getParameter('tables.auth_provider_oauth_account_assoc');

        $tables = [
            $tokens => [
                'auth.provider.oauth.service.discord',
                'auth.provider.oauth.service.github',
                'auth.provider.oauth.service.microsoft',
                'auth.provider.oauth.service.reddit',
                'auth.provider.oauth.service.wordpress',
            ],

            $states => [
                'auth.provider.oauth.service.discord',
                'auth.provider.oauth.service.github',
                'auth.provider.oauth.service.microsoft',
                'auth.provider.oauth.service.reddit',
                'auth.provider.oauth.service.wordpress',
            ],

            $accounts => [
                'discord',
                'github',
                'microsoft',
                'reddit',
                'wordpress',
            ],
        ];

        $this->db->sql_transaction('begin');

        foreach ($tables as $table => $providers) {
            foreach ($providers as $provider) {
                $sql = 'DELETE FROM ' . $table . "
					WHERE provider = '" . $this->db->sql_escape($provider) . "'";
                $this->sql_query($sql);
            }
        }

        $this->db->sql_transaction('commit');
    }
}
