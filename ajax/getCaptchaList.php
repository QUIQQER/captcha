<?php

/**
 * This file contains package_quiqqer_frontend-users_ajax_frontend_register
 */

use QUI\Captcha\Handler;

/**
 * Get list of all installed Captcha modules
 *
 * @return array
 */
QUI::$Ajax->registerFunction(
    'package_quiqqer_captcha_ajax_getCaptchaList',
    function () {
        return Handler::getList();
    },
    array(),
    'Permission::checkAdminUser'
);
