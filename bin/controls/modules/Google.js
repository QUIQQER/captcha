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
            '$onGoogleCatpchaSuccess',
            '$renderV2',
            '$renderV3'
        ],

        options: {
            sitekey  : false,   // Google reCAPTCHA v2/v3 Site Key
            invisible: false,   // use invisible captcha
            v3       : false,   // use reCAPTCHA v3
        },

        initialize: function (options) {
            this.parent(options);

            this.Loader      = new QUILoader();
            this.$DisplayElm = null;

            this.$reloadChallengeOnPrematureClose = true;

            this.addEvents({
                onImport: this.$onImport
            });
        },

        /**
         * event: onImport
         */
        $onImport: function () {
            var self = this;

            this.Loader.inject(this.$Elm);
            this.Loader.show();

            if (window.loadingGoogleReCaptcha) {
                var waitForGoogleReCaptcha = setInterval(function () {
                    if (typeof grecaptcha !== 'undefined') {
                        clearInterval(waitForGoogleReCaptcha);
                        self.$onGoogleCaptchaLoaded();
                    }
                }, 200);

                return;
            }

            if (typeof grecaptcha !== 'undefined') {
                this.$onGoogleCaptchaLoaded();
                return;
            }

            window.$onGoogleCaptchaLoaded = this.$onGoogleCaptchaLoaded;
            window.loadingGoogleReCaptcha = true;

            if (this.getAttribute('v3')) {
                new Element('script', {
                    src  : 'https://www.google.com/recaptcha/api.js?onload=$onGoogleCaptchaLoaded&render=' + this.getAttribute('sitekey'),
                    async: true,
                    defer: true
                }).inject(document.head);
            } else {
                new Element('script', {
                    src  : 'https://www.google.com/recaptcha/api.js?onload=$onGoogleCaptchaLoaded&render=explicit',
                    async: true,
                    defer: true
                }).inject(document.head);
            }
        },

        /**
         * Callback function for Google api.js
         */
        $onGoogleCaptchaLoaded: function () {
            window.loadingGoogleReCaptcha = false;

            this.Loader.hide();

            this.$DisplayElm = this.$Elm.getElement('.quiqqer-captcha-google-display');

            if (this.getAttribute('v3')) {
                this.$renderV3();
            } else {
                this.$renderV2();
            }
        },

        /**
         * Render Google reCAPTCHA v2
         */
        $renderV2: function () {
            var self = this;

            var Options = {
                sitekey           : this.getAttribute('sitekey'),
                callback          : function (response) {
                    self.$reloadChallengeOnPrematureClose = false;
                    self.$onCaptchaSuccess(response);
                },
                'expired-callback': function () {
                    grecaptcha.reset();
                    //self.$onCaptchaExpired();
                },
                'error-callback'  : function () {
                    self.$reloadChallengeOnPrematureClose = false;
                }
            };

            if (this.getAttribute('invisible')) {
                Options.size = 'invisible';
            }

            grecaptcha.render(this.$DisplayElm, Options);

            if (self.getAttribute('invisible')) {
                grecaptcha.execute();

                // Wait for challenge window
                var wait = setInterval(function () {
                    var ChallengeWin = document.querySelector('iframe[src^="https://www.google.com/recaptcha"][src*="bframe"]');

                    if (ChallengeWin) {
                        var ObserverElm = ChallengeWin.getParent('div').getParent('div');

                        clearInterval(wait);

                        var Observer = new MutationObserver(function (mutations) {
                            if (!self.$reloadChallengeOnPrematureClose) {
                                return;
                            }

                            if (ObserverElm &&
                                (ObserverElm.style.visibility === 'hidden' ||
                                    ObserverElm.style.opacity === 0)) {

                                (function () {
                                    grecaptcha.execute();
                                }).delay(500);
                            }
                        });

                        Observer.observe(ObserverElm, {
                            attributes     : true,
                            attributeFilter: ['style']
                        });
                    }
                }, 1000);
            }
        },

        /**
         * Render Google reCAPTCHA v3
         */
        $renderV3: function () {
            var self = this;

            grecaptcha.ready(function () {
                // refresh automatically every 120 seconds to prevent timeout
                setInterval(function () {
                    grecaptcha.execute(self.getAttribute('sitekey'), {action: 'submit'}).then(function (token) {
                        console.log(token);
                        self.$onCaptchaSuccess(token);
                    });
                }, 120000);
            });
        }
    });
});