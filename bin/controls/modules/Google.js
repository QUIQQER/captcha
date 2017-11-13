/**
 * Main CAPTCHA control that displays the current default CAPTCHA
 *
 * @module package/quiqqer/captcha/bin/controls/modules/Google
 * @author www.pcsg.de (Patrick Müller)
 */
define('package/quiqqer/captcha/bin/controls/modules/Google', [

    'qui/QUI',
    'qui/controls/Control',
    'qui/controls/loader/Loader',

    'Ajax'

], function (QUI, QUIControl, QUILoader, QUIAjax) {
    "use strict";

    return new Class({

        Extends: QUIControl,
        Type   : 'package/quiqqer/captcha/bin/controls/modules/Google',

        Binds: [
            '$onImport',
            '$onGoogleCaptchaLoaded'
        ],

        options: {
            clientid: false // Google API Client ID
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

            window.onGoogleCaptchaLoaded = this.$onGoogleCaptchaLoaded;

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
            this.Loader.hide();

            console.log("LOADED!");
            console.log(this.getAttribute('clientId'));
        }
    });
});