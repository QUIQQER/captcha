<?php

namespace QUI\Captcha;

use QUI;
use QUI\Controls\Control;
use QUI\Utils\System\File;

/**
 * Class Handler
 *
 * Handles captcha modules
 */
class Handler
{
    /**
     * Get Control of the currently configures captcha module (if none set use default)
     *
     * @return Control|false
     */
    public static function getDefaultCaptchaModuleControl()
    {
        $defaultModule = QUI::getPackage('quiqqer/captcha')->getConfig()->get('modules', 'defaultCaptcha');
        $defaultModuleClass = self::getCaptchaModule($defaultModule);

        if (!$defaultModuleClass) {
            return false;
        }

        return call_user_func($defaultModuleClass . '::getControl');
    }

    /**
     * Validates a Captcha response with a Captcha module
     *
     * @param string $response
     * @param string $module (optional) - Captcha module name [default: Default Captcha module]
     * @return bool
     */
    public static function isResponseValid($response, $module = null)
    {
        if (is_null($module)) {
            $module = QUI::getPackage('quiqqer/captcha')->getConfig()->get('modules', 'defaultCaptcha');
        }

        $moduleClass = self::getCaptchaModule($module);

        if (!$moduleClass) {
            return false;
        }

        return call_user_func($moduleClass . '::isValid', $response);
    }

    /**
     * Check if a Captcha module required JavaScript
     *
     * @param string $module (optional) - Captcha module name [default: Default Captcha module]
     * @return bool
     */
    public static function requiresJavaScript($module = null)
    {
        if (is_null($module)) {
            $module = QUI::getPackage('quiqqer/captcha')->getConfig()->get('modules', 'defaultCaptcha');
        }

        $moduleClass = self::getCaptchaModule($module);

        if (!$moduleClass) {
            return false;
        }

        return call_user_func($moduleClass . '::requiresJavaScript');
    }

    /**
     * Get Captcha module by name
     *
     * @param string $name
     * @return string - class path of Captcha module
     */
    public static function getCaptchaModule($name)
    {
        $class = 'QUI\\Captcha\\Modules\\' . $name;

        if (class_exists($class)) {
            return $class;
        }

        return false;
    }

    /**
     * Get list of all Captcha modules
     *
     * @return array
     */
    public static function getList()
    {
        $modules = array();

        foreach (File::readDir(dirname(__FILE__) . '/Modules', true) as $file) {
            $class     = 'QUI\\Captcha\\Modules\\' . basename($file, '.php');

            $modules[] = array(
                'name'        => call_user_func($class . '::getModuleName'),
                'title'       => call_user_func($class . '::getTitle'),
                'description' => call_user_func($class . '::getDescription')
            );
        }

        return $modules;
    }
}
