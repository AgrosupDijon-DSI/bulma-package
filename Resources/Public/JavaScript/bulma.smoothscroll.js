document.addEventListener('DOMContentLoaded', () => {

    // SmoothScroll initialization
    var scroll = new SmoothScroll('a[href*="#"]', {
        speed: 300,
        updateURL: false
    });

    // Loose focus on html after scroll to avoid firefox outline
    var logScrollEvent = function (event) {
        if(event.detail.anchor.tagName == "HTML"){
            event.detail.anchor.blur();
        }
    };

    // Listen for scroll events
    window.addEventListener('scrollStop', logScrollEvent, false);

    // Get all "scroll-top" elements
    var scrollTopElements = document.querySelectorAll('.scroll-top');

    // Check if there are any "scroll-top" elements
    if (scrollTopElements.length > 0) {

        // Hide & Show .scroll-top link on scroll
        window.addEventListener('scroll', () => {
            if(window.scrollY > 300){
                scrollTopElements.forEach( el => {
                    if(!el.classList.contains('scroll-top-visible')){
                        el.classList.add('scroll-top-visible');
                    }
                });
            } else {
                scrollTopElements.forEach( el => {
                    if(el.classList.contains('scroll-top-visible')){
                        el.classList.remove('scroll-top-visible');
                    }
                });
            }
        });
    }
});
