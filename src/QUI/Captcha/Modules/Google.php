<?php

namespace QUI\Captcha\Modules;

use QUI;
use QUI\Captcha\Modules\Google\Control;

class Google extends QUI\Captcha\AbstractCaptcha
{
    /**
     * Get control to show captcha
     *
     * @return Control
     */
    public static function getControl()
    {
        return new Control();
    }

    /**
     * Validate captcha data
     *
     * @param string $data
     * @return bool
     */
    public static function isValid($data)
    {

    }

    /**
     * Get Google API Client ID
     *
     * @return string|false
     */
    public static function getClientId()
    {
        return QUI::getPackage('quiqqer/captcha')->getConfig()->getValue('google', 'clientId');
    }
}
