/**
 * Main CAPTCHA control that displays the current default CAPTCHA
 *
 * @module package/quiqqer/captcha/bin/controls/CaptchaDisplay
 * @author www.pcsg.de (Patrick Müller)
 */
define('package/quiqqer/captcha/bin/controls/CaptchaDisplay', [

    'qui/QUI',
    'qui/controls/Control',
    'qui/controls/loader/Loader',
    'utils/Controls',

    'Ajax'

], function (QUI, QUIControl, QUILoader, QUIControlUtils, QUIAjax) {
    "use strict";

    return new Class({

        Extends: QUIControl,
        Type   : 'package/quiqqer/captcha/bin/controls/CaptchaDisplay',

        Binds: [
            '$onInject',
            '$getCurrentCaptchaControl'
        ],

        initialize: function (options) {
            this.parent(options);

            this.Loader          = new QUILoader();
            this.$CaptchaControl = null;

            this.addEvents({
                onInject: this.$onInject
            });
        },

        /**
         * event: onInject
         */
        $onInject: function () {
            var self = this;

            this.Loader.inject(this.$Elm);
            this.Loader.show();

            this.$getCurrentCaptchaControl().then(function (captchaControlHtml) {
                self.$Elm.set('html', captchaControlHtml);

                QUI.parse(self.$Elm).then(function () {
                    self.Loader.hide();
                });
            });
        },

        /**
         * Get Captcha control
         *
         * @return {Promise}
         */
        getCaptchaControl: function () {
            if (this.$CaptchaControl) {
                return Promise.resolve(this.$CaptchaControl);
            }

            return QUIControlUtils.getControlByElement(
                this.$Elm.getElement('.quiqqer-captcha-control')
            );
        },

        /**
         * Set settings to input
         */
        $getCurrentCaptchaControl: function () {
            return new Promise(function (resolve, reject) {
                QUIAjax.get(
                    'package_quiqqer_captcha_ajax_getCurrentCaptchaControl', resolve, {
                        'package': 'quiqqer/captcha',
                        onError  : reject
                    }
                )
            });
        }
    });
});