/**
 * Select for installed CAPTCHA modules
 *
 * @module package/quiqqer/captcha/bin/controls/settings/CaptchaSelect
 * @author www.pcsg.de (Patrick Müller)
 */
define('package/quiqqer/captcha/bin/controls/settings/CaptchaSelect', [

    'qui/controls/buttons/Select',
    'qui/controls/loader/Loader',

    'Ajax'

], function (QUISelect, QUILoader, QUIAjax) {
    "use strict";

    return new Class({

        Extends: QUISelect,
        Type   : 'package/quiqqer/captcha/bin/controls/settings/Captcha',

        Binds: [
            '$onInject',
            '$onChange',
            '$load'
        ],

        options: {
            showIcons: false
        },

        initialize: function (options) {
            this.parent(options);

            this.Loader = new QUILoader();

            this.addEvents({
                onImport: this.$onImport,
                onChange: this.$onChange
            });
        },

        /**
         * event: onInject
         */
        $onImport: function () {
            this.$Input      = this.getElm();
            this.$Input.type = 'hidden';

            var Select = this.create();
            Select.inject(this.$Input, 'after');

            this.Loader.inject(Select);

            Select.addClass('field-container-field');

            this.$load();
        },

        /**
         * Load captcha list and add entries
         */
        $load: function () {
            var self = this;

            this.Loader.show();

            console.log(this);

            QUIAjax.get(
                'package_quiqqer_captcha_ajax_getCaptchaList', function (modules) {
                    for (var i = 0, len = modules.length; i < len; i++) {
                        self.appendChild(
                            modules[0].title,
                            modules[0].name
                        );
                    }

                    if (self.$Input.value !== '') {
                        self.setValue(self.$Input.value);
                    }

                    self.Loader.hide();
                }, {
                    'package': 'quiqqer/captcha',
                    onError  : function (e) {
                        console.error(e.getMessage());
                    }
                }
            )
        },

        /**
         * event: onChange
         */
        $onChange: function () {
            this.$Input.value = this.getValue();
        }
    });
});