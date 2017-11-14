<?php

/**
 * This file contains QUI\Captcha\Controls\CaptchaDisplay
 */

namespace QUI\Captcha\Controls;

use QUI;
use QUI\Captcha\Handler;

/**
 * Class CaptchaDisplay
 *
 * Displays CAPTCHA
 */
class CaptchaDisplay extends QUI\Control
{
    /**
     * ControlWrapper constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->addCSSClass('quiqqer-captcha-display');
        $this->setJavaScriptControl('package/quiqqer/captcha/bin/controls/CaptchaDisplay');
    }

    /**
     * @return string
     */
    public function getBody()
    {
        $Engine = QUI::getTemplateManager()->getEngine();

        $Engine->assign(array(
            'ModuleControl' => Handler::getDefaultCaptchaModuleControl()
        ));

        return $Engine->fetch(dirname(__FILE__) . '/CaptchaDisplay.html');
    }
}
