<?php

namespace QUI\Captcha\Modules\GoogleV3;

use QUI;
use QUI\Captcha\Modules\Google\Control as GoogleControl;

/**
 * Class Controls
 *
 * Google reCAPTCHA v3 Control
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
        $this->setJavaScriptControlOption('v3', true);
    }
}
