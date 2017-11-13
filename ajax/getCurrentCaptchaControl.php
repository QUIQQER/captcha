<?php

/**
 * This file contains package_quiqqer_frontend-users_ajax_frontend_register
 */

use QUI\Captcha\Handler;

/**
 * Get current captcha control
 *
 * @return string - Captcha control HTML
 */
QUI::$Ajax->registerFunction(
    'package_quiqqer_captcha_ajax_getCurrentCaptchaControl',
    function () {
        return Handler::getCaptchaControl()->create();
    },
    array()
);
