document.addEventListener('DOMContentLoaded', () => {

    var dropdowns = document.querySelectorAll('.dropdown');
    var isOutOfViewport = function (elem) {

        // Get element's bounding
        var bounding = elem.getBoundingClientRect();

        // Check if it's out of the viewport on each side
        var out = {};
        out.top = bounding.top < 0;
        out.left = bounding.left < 0;
        out.bottom = bounding.bottom > (window.innerHeight || document.documentElement.clientHeight);
        out.right = bounding.right > (window.innerWidth || document.documentElement.clientWidth);
        out.any = out.top || out.left || out.bottom || out.right;
        out.all = out.top && out.left && out.bottom && out.right;

        return out;

    };

    dropdowns.forEach(function (dropdown, index) {

        const originalClasses = dropdown.className;

        dropdown.addEventListener('click', () => {
            dropdown.classList.toggle('is-active');
            var isOut = isOutOfViewport(dropdown.children[1]);
            if(isOut.right && !isOut.left){
                dropdown.classList.add('is-right');
                if(isOutOfViewport(dropdown.children[1]).left){
                    dropdown.classList.remove('is-right');
                }
            }
            if(isOut.left && !isOut.right){
                dropdown.classList.remove('is-right');
                if(isOutOfViewport(dropdown.children[1]).right){
                    dropdown.classList.add('is-right');
                }
            }
            if (isOut.bottom && !isOut.top) {
                dropdown.classList.add('is-up');
                if(isOutOfViewport(dropdown.children[1]).top){
                    dropdown.classList.remove('is-up');
                }
            }
            if (isOut.top && !isOut.bottom) {
                dropdown.classList.remove('is-up');
                if(isOutOfViewport(dropdown.children[1]).bottom){
                    dropdown.classList.add('is-up');
                }
            }
        });

        window.addEventListener('click', function(e){
            if(!dropdown.contains(e.target)){
                dropdown.className = originalClasses;
            }
        });
    });
});
