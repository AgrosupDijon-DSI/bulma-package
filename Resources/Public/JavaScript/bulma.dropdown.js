document.addEventListener('DOMContentLoaded', () => {

    const dropdowns = document.querySelectorAll('.dropdown');
    const hoverableNavbarDropdowns = document.querySelectorAll('.navbar-item.has-dropdown.is-hoverable:not(.is-mega)');

    const isOutOfViewport = function (elem) {
        // Get element's bounding
        let bounding = elem.getBoundingClientRect();

        // Check if it's out of the viewport on each side
        let out = {};
        out.top = bounding.top < 0;
        out.left = bounding.left < 0;
        out.bottom = bounding.bottom > (window.innerHeight || document.documentElement.clientHeight);
        out.right = bounding.right > (window.innerWidth || document.documentElement.clientWidth);
        out.any = out.top || out.left || out.bottom || out.right;
        out.all = out.top && out.left && out.bottom && out.right;

        return out;
    };

    function fixPositionX(dropdownElement, positionerElement){
        let isOut = isOutOfViewport(dropdownElement);

        if(isOut.right && !isOut.left){
            positionerElement.classList.add('is-right');
            if(isOutOfViewport(dropdownElement).left){
                positionerElement.classList.remove('is-right');
            }
        }
        if(isOut.left && !isOut.right){
            positionerElement.classList.remove('is-right');
            if(isOutOfViewport(dropdownElement).left){
                positionerElement.classList.add('is-right');
            }
        }
    }

    function fixPositionY(dropdownElement, positionerElement, className = 'is-up'){
        let isOut = isOutOfViewport(dropdownElement);

        if (isOut.bottom && !isOut.top) {
            positionerElement.classList.add(className);
            if(isOutOfViewport(dropdownElement).top){
                positionerElement.classList.remove(className);
            }
        }
        if (isOut.top && !isOut.bottom) {
            positionerElement.classList.remove(className);
            if(isOutOfViewport(dropdownElement).bottom){
                positionerElement.classList.add(className);
            }
        }
    }

    hoverableNavbarDropdowns.forEach(function (dropdown, index) {
        let dropdownMenu = dropdown.children[1];
        const originalDropdownClasses = dropdown.className;
        const originalDropdownMenuClasses = dropdownMenu.className;

        dropdown.addEventListener('mouseenter', () => {
            fixPositionX(dropdownMenu, dropdownMenu);
            fixPositionY(dropdownMenu, dropdown, 'has-dropdown-up');
        });

        dropdown.addEventListener('mouseleave', () => {
            dropdown.className = originalDropdownClasses;
            dropdownMenu.className = originalDropdownMenuClasses;
        });
    });

    dropdowns.forEach(function (dropdown, index) {
        const originalClasses = dropdown.className;
        let dropdownMenu = dropdown.children[1];

        dropdown.addEventListener('click', () => {
            dropdown.classList.toggle('is-active');
            fixPositionX(dropdownMenu, dropdown);
            fixPositionY(dropdownMenu, dropdown);
        });

        window.addEventListener('click', function(e){
            if(!dropdown.contains(e.target)){
                dropdown.className = originalClasses;
            }
        });
    });

});
