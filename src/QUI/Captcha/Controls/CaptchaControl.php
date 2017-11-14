<?php

/**
 * This file contains QUI\Captcha\Controls\CaptchaControl
 */

namespace QUI\Captcha\Controls;

use QUI;

/**
 * Class CaptchaControl
 *
 * Parent Control class for Captcha module controls
 */
class CaptchaControl extends QUI\Control
{
    /**
     * ControlWrapper constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->addCSSClass('quiqqer-captcha-control');
    }
}
