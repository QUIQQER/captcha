/**
 * Google reCAPTCHA v2
 *
 * @module package/quiqqer/captcha/bin/controls/modules/Google
 * @author www.pcsg.de (Patrick Müller)
 */
define('package/quiqqer/captcha/bin/controls/modules/Google', [

    'package/quiqqer/captcha/bin/controls/Captcha',
    'qui/controls/loader/Loader'

], function (Captcha, QUILoader) {
    "use strict";

    return new Class({

        Extends: Captcha,
        Type   : 'package/quiqqer/captcha/bin/controls/modules/Google',

        Binds: [
            '$onImport',
            '$onGoogleCaptchaLoaded',
            '$onGoogleCatpchaSuccess'
        ],

        options: {
            sitekey: false // Google reCAPTCHA v2 Site Key
        },

        initialize: function (options) {
            this.parent(options);

            this.Loader = new QUILoader();

            this.addEvents({
                onImport: this.$onImport
            });
        },

        /**
         * event: onImport
         */
        $onImport: function () {
            this.Loader.inject(this.$Elm);
            this.Loader.show();

            window.$onGoogleCaptchaLoaded = this.$onGoogleCaptchaLoaded;

            new Element('script', {
                src  : 'https://www.google.com/recaptcha/api.js?onload=$onGoogleCaptchaLoaded&render=explicit',
                async: true,
                defer: true
            }).inject(document.head);
        },

        /**
         * Callback function for Google api.js
         */
        $onGoogleCaptchaLoaded: function () {
            var self = this;

            this.Loader.hide();

            var DisplayElm = this.$Elm.getElement('.quiqqer-captcha-google-display');

            grecaptcha.render(
                DisplayElm, {
                    sitekey           : this.getAttribute('sitekey'),
                    callback          : function (response) {
                        self.$onCaptchaSuccess(response);
                    },
                    'expired-callback': function () {
                        self.$onCaptchaExpired();
                    }
                }
            );
        }
    });
});