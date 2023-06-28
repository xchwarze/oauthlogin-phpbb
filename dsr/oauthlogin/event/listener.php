<?php
/**
 *
 * Extend OAuth login. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023, DSR! https://github.com/xchwarze
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace dsr\oauthlogin\event;

use phpbb\language\language;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{

    /* @var language */
    protected $language;

    /**
     * Constructor
     *
     * @param language $language Language object
     */
    public function __construct(language $language)
    {
        $this->language = $language;
    }

    /**
     * Assign functions defined in this class to event listeners in the core
     *
     * @return array
     */
    static public function getSubscribedEvents()
    {
        return [
            'core.user_setup_after' => 'user_setup_after',
        ];
    }

    /**
     * Load extension language file during after user set up
     *
     * @return void
     */
    public function user_setup_after()
    {
        $this->language->add_lang('common', 'dsr/oauthlogin');
    }
}
