document.addEventListener('DOMContentLoaded', () => {
    const bulmaCollapsibleInstances = bulmaCollapsible.attach('.is-collapsible');

    const isInViewport = function (elem) {
        const bounding = elem.getBoundingClientRect();
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
            sleep(250).then(() => {
                if(!isInViewport(accordionElement.element.previousSibling)){
                    accordionElement.element.previousSibling.scrollIntoView();
                }
            });
        });

        const currentAnchor = (document.URL.split('#').length > 1) ? document.URL.split('#')[1] : null;
        if(currentAnchor){
            if(accordionElement.element.id === currentAnchor){
                accordionElement.expand();
            }
        }
    });

});
