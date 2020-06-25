document.addEventListener('DOMContentLoaded', () => {
    var carousels = document.querySelectorAll('.carousel');
    var flkty = [];
    carousels.forEach(function (elem, index) {
        flkty[index] = new Flickity(elem, {
            // options
            contain: true,
            autoPlay: Number(elem.dataset.autoplay),
            wrapAround: (elem.dataset.wraparound == 'true' ? true : false),
            cellAlign: elem.dataset.cellalign,
            pageDots: (elem.dataset.pagedots == 'true' ? true : false),
            prevNextButtons: (elem.dataset.prevnextbuttons == 'true' ? true : false),
            fade: (elem.dataset.fade == 'true' ? true : false),
            // Number(false) give 'NaN' so rendering will be what's expected
            groupCells: (elem.dataset.groupcells == 'true' ? true : Number(elem.dataset.groupcells))
        });
    });
});
