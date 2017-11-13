<?php

namespace QUI\Captcha;

use QUI\Controls\Control;
use QUI\Locale;

interface CaptchaInterface
{
    /**
     * Get control to show captcha
     *
     * @return Control
     */
    public static function getControl();

    /**
     * Validate captcha data
     *
     * @param string $data
     * @return bool
     */
    public static function isValid($data);

    /**
     * Get Captcha module title
     *
     * @param Locale $Locale (optional) - if omitted use \QUI::getLocale()
     * @return string
     */
    public static function getTitle($Locale = null);

    /**
     * Get Captcha module description
     *
     * @param Locale $Locale (optional) - if omitted use \QUI::getLocale()
     * @return string
     */
    public static function getDescription($Locale = null);

    /**
     * Get Captcha module name
     *
     * @return string
     */
    public static function getModuleName();
}
