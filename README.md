QUIQQER Captcha
========

This plugin provides Captcha controls to implement CAPTCHAs for your website. It also provides an API
to develop your own CAPTCHA or implement third party CAPTCHAs.

Implementation of Google reCAPTCHA is included.

Package Name:

    quiqqer/captcha


Features
--------
* Captcha Control that can be implemented anywhere
* API to implement own CAPTCHA solutions
* Google reCAPTCHA included

Installation
------------
The Package Name is: quiqqer/captcha

Usage
----------
### Frontend
```js
require(['package/quiqqer/captcha/bin/controls/CaptchaDisplay'], function(CaptchaDisplay) {
    var MyCaptchaDisplay = new CaptchaDisplay().inject(document.body);
    
    MyCaptchaDisplay.getCaptchaControl().then(function (CaptchaControl) {
        CaptchaControl.addEvents({
            onSuccess: function (response) {
                // CAPTCHA successfully solved -> response can be send to backend for validation
                sendToBackendForValidation(response);
            },
            onExpired: function () {
                // CAPTCHA is expired -> reload or show info message
            }
        });
    }, function () {
        // error
    });
});
```

### Backend
```php
$isReponseValid = \QUI\Captcha\Handler::isResponseValid($response);

if ($isResponseValid) {
    // success! user is human (probably)
} else {
    // failure! user is a bot (probably)
}
```

Contribute
----------
- Project: https://dev.quiqqer.com/quiqqer/captcha
- Issue Tracker: https://dev.quiqqer.com/quiqqer/captcha/issues
- Source Code: https://dev.quiqqer.com/quiqqer/captcha/tree/master

Support
-------
If you found any errors or have wishes or suggestions for improvement,
please contact us by email at support@pcsg.de.

We will transfer your message to the responsible developers.

License
-------
PCSG QL-1.0, CC BY-NC-SA 4.0