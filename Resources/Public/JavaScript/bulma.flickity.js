import Flickity from "flickity"
import 'flickity-fade'

const carousels = document.querySelectorAll('.carousel');
let flkty = [];
carousels.forEach(function (elem, index) {
  flkty[index] = new Flickity(elem, {
    // options
    contain: true,
    autoPlay: Number(elem.dataset.autoplay),
    wrapAround: (elem.dataset.wraparound === 'true'),
    cellAlign: elem.dataset.cellalign,
    pageDots: (elem.dataset.pagedots === 'true'),
    prevNextButtons: (elem.dataset.prevnextbuttons === 'true'),
    fade: (elem.dataset.fade === 'true'),
    // Number(false) give 'NaN' so rendering will be what's expected
    groupCells: (elem.dataset.groupcells === 'true' ? true : Number(elem.dataset.groupcells))
  });
});
