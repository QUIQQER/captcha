<?php

namespace QUI\Captcha;

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
     * @return Control
     */
    public static function getCaptchaControl()
    {

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
