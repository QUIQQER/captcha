/**
 * Captcha JavaScript control parent class
 *
 * @module package/quiqqer/captcha/bin/controls/Captcha
 * @author www.pcsg.de (Patrick Müller)
 *
 * @event onSuccess [captchaResponse, this] - fires if Captcha process successful
 * @event onExpired [this] - fires if Captcha expires
 */
define('package/quiqqer/captcha/bin/controls/Captcha', [

    'qui/controls/Control'

], function (QUIControl) {
    "use strict";

    return new Class({

        Extends: QUIControl,
        Type   : 'package/quiqqer/captcha/bin/controls/Captcha',

        Binds: [
            '$onCatpchaSuccess',
            '$onCaptchaExpired'
        ],

        /**
         * Executed on successful Captcha input
         *
         * @param {String} response
         */
        $onCaptchaSuccess: function (response) {
            this.fireEvent('success', [response, this]);
        },

        /**
         * Executed if Captcha expires
         */
        $onCaptchaExpired: function () {
            this.fireEvent('expired', [this]);
        }
    });
});