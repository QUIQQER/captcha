<?php

/**
 * This file contains QUI\FrontendUsers\Controls\Profile\ControlWrapper
 */

namespace QUI\Captcha\Modules\Google;

use QUI;
use QUI\Captcha\Modules\Google;

/**
 * Class Controls
 *
 * Google reCAPTCHA Control
 */
class Control extends QUI\Captcha\Controls\CaptchaControl
{
    /**
     * ControlWrapper constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->addCSSClass('quiqqer-captcha-google');

        $this->setJavaScriptControl('package/quiqqer/captcha/bin/controls/modules/Google');
        $this->setJavaScriptControlOption('sitekey', Google::getSiteKey());
    }

    /**
     * @return string
     */
    public function getBody()
    {
        $Engine = QUI::getTemplateManager()->getEngine();
        return $Engine->fetch(dirname(__FILE__) . '/Control.html');
    }
}
