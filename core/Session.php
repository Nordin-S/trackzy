<?php
/**
 * Created by PhpStorm
 * USER: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/16/2022
 * TIME: 2:21 PM
 */

namespace app\core;

class Session
{

    protected const FLASH_KEYS = 'flash_messages';

    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEYS] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            // Flag to be removed
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_KEYS] = $flashMessages;
    }

    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEYS][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEYS][$key]['value'] ?? false;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function unsetSessionKey($key)
    {
        unset($_SESSION[$key]);
    }

    public function __destruct()
    {
        // Remove all the flagged flash messages
        $flashMessages = $_SESSION[self::FLASH_KEYS] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEYS] = $flashMessages;
    }
}