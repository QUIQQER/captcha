<?php

/**
 * This file contains QUI\FrontendUsers\Controls\Profile\ControlWrapper
 */

namespace QUI\Captcha\Modules\GoogleInvisible;

use QUI;
use QUI\Captcha\Modules\Google\Control as GoogleControl;

/**
 * Class Controls
 *
 * Google reCAPTCHA Control
 */
class Control extends GoogleControl
{
    /**
     * ControlWrapper constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setJavaScriptControlOption('invisible', true);
    }
}
