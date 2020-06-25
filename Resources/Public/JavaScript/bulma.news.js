document.addEventListener('DOMContentLoaded', () => {

    const $newsBackLinks = Array.prototype.slice.call(document.querySelectorAll('.news-backlink-wrap a'), 0);

    if ($newsBackLinks.length > 0) {

        if (document.referrer.indexOf(window.location.hostname) != -1) {
            $newsBackLinks.forEach(el => {
                el.setAttribute('href', 'javascript:history.back();');
            });
        }
    }

});
