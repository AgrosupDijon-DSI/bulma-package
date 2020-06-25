/* ========================================================================
 * Cookie Consent
 * ======================================================================== */

window.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('cookieconsent')) {

        // Default Options
        var cookieConsentOptions = {
            layout: 'basic',
            layouts: {
                'basic': '<div class="cc-container">{{messagelink}}{{compliance}}</div>',
                'basic-close': '<div class="cc-container">{{messagelink}}{{compliance}}{{close}}</div>',
                'basic-header': '<div class="cc-container">{{header}}{{message}}{{link}}{{compliance}}</div>',
            },
            cookie: {
                domain: window.location.hostname,
                expiryDays: 365,
            },
            compliance: {
                'opt-in': '<div class="cc-compliance cc-highlight">{{deny}}{{allow}}</div>',
            },
            revokeBtn: '<div class="cc-revoke {{classes}}">{{policy}}</div>',
            content: {
                header: "Cookies used on the website!",
                message: "This website uses cookies to ensure you get the best experience on our website.",
                dismiss: "Got it!",
                allow: "Allow cookies",
                deny: "Decline",
                link: "Learn more",
                policy: "Cookie settings",
                href: '',
            },
            law: {
                countryCode: null,
                regionalLaw: true,
            },
            type: "info",
            position: "bottom",
            revokable: false,
            static: false,
            location: true,
            showLink: false,
        };

        // Supported Options
        var cookieConsentSupportedOptions = [
            'layout',
            'cookie.expiryDays',
            'content.header',
            'content.message',
            'content.dismiss',
            'content.allow',
            'content.deny',
            'content.link',
            'content.href',
            'content.policy',
            'type',
            'position',
            'law.countryCode',
            'law.regionalLaw',
            'revokable',
            'static',
            'location',
        ];

        // Functions
        var cookieConsentFunctions = {};
        cookieConsentFunctions.updateCookieConsentOptions = function(options, path, value) {
            stack = path.split('.');
            while (stack.length > 1) {
                key = stack.shift();
                options = options[key];
            }
            options[stack.shift()] = value;
        };

        // Settings
        settings = document.querySelectorAll('[data-cookieconsent-setting]');
        for (i = 0; i < settings.length; ++i) {
            setting = settings[i].dataset.cookieconsentSetting;
            value = settings[i].dataset.cookieconsentValue;
            if (parseInt(value, 10) == value) {
                value = parseInt(value, 10);
            }
            if (cookieConsentSupportedOptions.indexOf(setting) != -1) {
                cookieConsentFunctions.updateCookieConsentOptions(
                    cookieConsentOptions,
                    setting,
                    value
                );
                if (setting === 'content.href') {
                    cookieConsentFunctions.updateCookieConsentOptions(
                        cookieConsentOptions,
                        'showLink',
                        (value !== '') ? true : false
                    );
                }
            }
            settings[i].parentNode.removeChild(settings[i]);
        }
        delete settings;

        // Events
        cookieConsentOptions.onPopupOpen = function() {
            var eventOpen = document.createEvent('Event');
            eventOpen.initEvent('asd.cookie.popupopen', true, true);
            window.dispatchEvent(eventOpen);
            var type = this.options.type;
            var event = document.createEvent('Event');
            if (type == "info" || type == "opt-out") {
                event.initEvent('asd.cookie.enable', true, true);
                window.dispatchEvent(event);
            }
            if(type == "opt-in"){
                event.initEvent('asd.cookie.disable', true, true);
                window.dispatchEvent(event);
            }
        };
        cookieConsentOptions.onPopupClose = function () {
            var event = document.createEvent('Event');
            event.initEvent('asd.cookie.popupclose', true, true);
            window.dispatchEvent(event);
        };
        cookieConsentOptions.onInitialise = function (status) {
            var didConsent = this.hasConsented();
            var event = document.createEvent('Event');
            if (didConsent) {
                event.initEvent('asd.cookie.enable', true, true);
                window.dispatchEvent(event);
            }
            if (!didConsent) {
                event.initEvent('asd.cookie.disable', true, true);
                window.dispatchEvent(event);
            }
        };
        cookieConsentOptions.onStatusChange = function (status, chosenBefore) {
            var type = this.options.type;
            var didConsent = this.hasConsented();
            var event = document.createEvent('Event');
            if (didConsent && type == 'opt-in') {
                event.initEvent('asd.cookie.enable', true, true);
                window.dispatchEvent(event);
            }
            if (!didConsent && (type == 'opt-in' || type == 'opt-out')) {
                event.initEvent('asd.cookie.disable', true, true);
                window.dispatchEvent(event);
            }
        };
        cookieConsentOptions.onRevokeChoice = function () {
            var event = document.createEvent('Event');
            event.initEvent('asd.cookie.revoke', true, true);
            window.dispatchEvent(event);
        };

        // Initialize
        cookieConsentOptions.container = document.getElementById('cookieconsent');
        window.cookieconsent.initialise(cookieConsentOptions);

    }
});
