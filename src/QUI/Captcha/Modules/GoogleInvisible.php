<?php

namespace QUI\Captcha\Modules;

use QUI\Captcha\Modules\GoogleInvisible\Control;

class GoogleInvisible extends Google
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
     * Check if this CAPTCHA has a visible representation or not
     *
     * @return bool
     */
    public static function isInvisible()
    {
        return true;
    }
}
