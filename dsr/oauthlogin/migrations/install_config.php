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

use phpbb\db\migration\migration;

class install_config extends migration
{
    /**
     * {@inheritdoc}
     */
    public function effectively_installed()
    {
        return $this->config->offsetExists('auth_oauth_discord_key');
    }

    /**
     * {@inheritdoc}
     */
    public function update_data()
    {
        return [
            // discord
            ['config.add', ['auth_oauth_discord_key', '']],
            ['config.add', ['auth_oauth_discord_secret', '']],

            // github
            ['config.add', ['auth_oauth_github_key', '']],
            ['config.add', ['auth_oauth_github_secret', '']],

            // microsoft
            ['config.add', ['auth_oauth_microsoft_key', '']],
            ['config.add', ['auth_oauth_microsoft_secret', '']],
        ];
    }

}
