@if($cookieConsentConfig['enabled'] && ! $alreadyConsentedWithCookies)

    @include('vendor.cookie-consent.dialogContents')

    <script>

        window.laravelCookieConsent = (function () {

            const COOKIE_VALUE = 1;
            const COOKIE_DOMAIN = '{{ config('session.domain') ?? request()->getHost() }}';

            function consentWithCookies() {
                setCookie('{{ $cookieConsentConfig['cookie_name'] }}', COOKIE_VALUE, {{ $cookieConsentConfig['cookie_lifetime'] }});
                hideCookieDialog();
            }

            function declineCookies() {
                // Hide dialog without setting consent cookie
                // Shopping cart cookie is kept as it's strictly necessary for the webshop functionality
                hideCookieDialog();
            }

            function cookieExists(name) {
                return (document.cookie.split('; ').indexOf(name + '=' + COOKIE_VALUE) !== -1);
            }

            function hideCookieDialog() {
                const dialogs = document.getElementsByClassName('js-cookie-consent');

                for (let i = 0; i < dialogs.length; ++i) {
                    dialogs[i].style.display = 'none';
                }
            }

            function setCookie(name, value, expirationInDays) {
                const date = new Date();
                date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
                document.cookie = name + '=' + value
                    + ';expires=' + date.toUTCString()
                    + ';domain=' + COOKIE_DOMAIN
                    + ';path=/{{ config('session.secure') ? ';secure' : null }}'
                    + '{{ config('session.same_site') ? ';samesite='.config('session.same_site') : null }}';
            }

            if (cookieExists('{{ $cookieConsentConfig['cookie_name'] }}')) {
                hideCookieDialog();
            }

            const agreeButtons = document.getElementsByClassName('js-cookie-consent-agree');
            const declineButtons = document.getElementsByClassName('js-cookie-consent-decline');

            for (let i = 0; i < agreeButtons.length; ++i) {
                agreeButtons[i].addEventListener('click', consentWithCookies);
            }

            for (let i = 0; i < declineButtons.length; ++i) {
                declineButtons[i].addEventListener('click', declineCookies);
            }

            return {
                consentWithCookies: consentWithCookies,
                declineCookies: declineCookies,
                hideCookieDialog: hideCookieDialog
            };
        })();
    </script>

@endif
