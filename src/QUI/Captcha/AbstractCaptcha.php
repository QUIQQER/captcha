<?php

namespace QUI\Captcha;

use QUI;
use QUI\Locale;

abstract class AbstractCaptcha implements CaptchaInterface
{
    /**
     * Get Captcha module title
     *
     * @param Locale $Locale (optional) - if omitted use \QUI::getLocale()
     * @return string
     */
    public static function getTitle($Locale = null)
    {
        if (is_null($Locale)) {
            $Locale = QUI::getLocale();
        }

        $Locale->get('quiqqer/captcha', 'captcha.title.' . self::getModuleName());
    }

    /**
     * Get Captcha module description
     *
     * @param Locale $Locale (optional) - if omitted use \QUI::getLocale()
     * @return string
     */
    public static function getDescription($Locale = null)
    {
        if (is_null($Locale)) {
            $Locale = QUI::getLocale();
        }

        $Locale->get('quiqqer/captcha', 'captcha.description.' . self::getModuleName());
    }

    /**
     * Get Captcha module name
     *
     * @return string
     */
    public static function getModuleName()
    {
        $parts = explode('\\', get_class());
        return array_pop($parts);
    }
}
