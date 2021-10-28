document.addEventListener('DOMContentLoaded', () => {
    const bulmaCollapsibleInstances = bulmaCollapsible.attach('.is-collapsible');
    var scroll = new SmoothScroll();

    var isInViewport = function (elem) {
        var bounding = elem.getBoundingClientRect();
        return (
            bounding.top >= 0 &&
            bounding.bottom <= (window.innerHeight || document.documentElement.clientHeight)
        );
    };

    const sleep = (milliseconds) => {
        return new Promise(resolve => setTimeout(resolve, milliseconds))
    };

    bulmaCollapsibleInstances.forEach(accordionElement => {
        accordionElement.on('before:expand', (e) => {
            sleep(200).then(() => {
                if(!isInViewport(accordionElement.element.previousSibling)){
                    scroll.animateScroll(accordionElement.element.previousSibling, 0, {speed: 300, updateURL: false});
                }
            });
        });

        var currentAnchor = (document.URL.split('#').length > 1) ? document.URL.split('#')[1] : null;
        if(currentAnchor){
            if(accordionElement.element.id == currentAnchor){
                accordionElement.expand();
            }
        }
    });

});
