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
class Control extends QUI\Control
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
        $this->setJavaScriptControlOption('clientid', Google::getClientId());
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
