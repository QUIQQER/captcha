<?php

namespace QUI\Captcha\Modules;

use QUI;
use QUI\Captcha\Modules\Google\Control;

class Google extends QUI\Captcha\AbstractCaptcha
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
     * Validate captcha data
     *
     * @param string $data
     * @return bool
     * @throws QUI\Exception
     */
    public static function isValid($data)
    {
        $url    = 'https://www.google.com/recaptcha/api/siteverify?';
        $params = array(
            'secret'   => self::getSecretKey(),
            'response' => $data
        );

        $url .= http_build_query($params);

        $validationResponse = file_get_contents($url);

        if (empty($validationResponse)) {
            QUI\System\Log::addError(
                'Google reCAPTCHA response could not be validated: Empty response.'
            );

            return false;
        }

        $validationResponse = json_decode($validationResponse, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            QUI\System\Log::addError(
                'Google reCAPTCHA response could not be validated: Response was no valid JSON.'
            );

            return false;
        }

        if (!empty($validationResponse['error-codes'])) {
            QUI\System\Log::addError(
                'Google reCAPTCHA response could not be validated: ' . implode(', ', $validationResponse['error-codes'])
            );

            return false;
        }

        return $validationResponse['success'];
    }

    /**
     * Get Google reCAPTCHA v2 Site Key
     *
     * @return string|false
     * @throws QUI\Exception
     */
    public static function getSiteKey()
    {
        return QUI::getPackage('quiqqer/captcha')->getConfig()->getValue('google', 'siteKey');
    }

    /**
     * Get Google reCAPTCHA v2 Secret Key
     *
     * @return string|false
     * @throws QUI\Exception
     */
    protected static function getSecretKey()
    {
        return QUI::getPackage('quiqqer/captcha')->getConfig()->getValue('google', 'secretKey');
    }

    /**
     * Does this Captcha module require JavaScript?
     *
     * @return bool
     */
    public static function requiresJavaScript()
    {
        return true;
    }
}
