<?php

namespace QUI\Captcha\Modules;

use QUI;
use QUI\Captcha\Modules\GoogleV3\Control;

/**
 * Class GoogleV3
 *
 * Captcha provider vor Google reCAPTCHA v3
 */
class GoogleV3 extends Google
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
        $params = [
            'secret'   => self::getSecretKey(),
            'response' => $data
        ];

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
                'Google reCAPTCHA response could not be validated: '.implode(', ', $validationResponse['error-codes'])
            );

            return false;
        }

        if (empty($validationResponse['success'])) {
            return false;
        }

        // Evaluate reCAPTCHA v3 score
        $score = (float)$validationResponse['score'];

        if ($score <= 0) {
            return false;
        }

        return true;
    }
}
