/**
 * Main CAPTCHA control that displays the current default CAPTCHA
 *
 * @module package/quiqqer/captcha/bin/controls/Captcha
 * @author www.pcsg.de (Patrick Müller)
 */
define('package/quiqqer/captcha/bin/controls/Captcha', [

    'qui/QUI',
    'qui/controls/Control',
    'qui/controls/loader/Loader',

    'Ajax'

], function (QUI, QUIControl, QUILoader, QUIAjax) {
    "use strict";

    return new Class({

        Extends: QUIControl,
        Type   : 'package/quiqqer/captcha/bin/controls/Captcha',

        Binds: [
            '$onInject',
            '$getCurrentCaptchaControl'
        ],

        initialize: function (options) {
            this.parent(options);

            this.Loader = new QUILoader();

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

            this.$getCurrentCaptchaControl().then(function(captchaControlHtml) {
                self.$Elm.set('html', captchaControlHtml);

                QUI.parse(self.$Elm).then(function() {
                    self.Loader.hide();
                });
            });
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