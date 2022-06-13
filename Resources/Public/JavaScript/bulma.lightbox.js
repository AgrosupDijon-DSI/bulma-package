document.addEventListener("DOMContentLoaded", () => {
    // slideshow vars:
    var ssRunning = false,
        ssDelay = 4000 /*ms*/,
        ssButtonClass = '.pswp__button--playpause',
        ssButton = null,
        slideshowAnimation = null;

    var gallery = null;

    /**
     * Add PhotoSwipe template to dom if lightbox elements exist.
     */
    if (document.querySelectorAll('a.lightbox').length > 0) {
        var photoswipeTemplate = document.createElement('template');
        photoswipeTemplate.innerHTML = '\
            <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">\
                <div class="pswp__bg"></div>\
                <div class="pswp__scroll-wrap">\
                    <div class="pswp__container">\
                        <div class="pswp__item"></div>\
                        <div class="pswp__item"></div>\
                        <div class="pswp__item"></div>\
                    </div>\
                    <div class="pswp__ui pswp__ui--hidden">\
                        <div class="pswp__top-bar">\
                            <div class="pswp__counter"></div>\
                            <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>\
                            <button class="pswp__button pswp__button--share" title="Share"></button>\
                            <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>\
                            <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>\
                            <button class="pswp__button pswp__button--playpause" title="Play Slideshow (Space bar)"></button>\
                            <div class="pswp__preloader">\
                                <div class="pswp__preloader__icn">\
                                    <div class="pswp__preloader__cut">\
                                        <div class="pswp__preloader__donut"></div>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                        <div class="pswp__progress"><span></span></div>\
                        <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">\
                            <div class="pswp__share-tooltip"></div> \
                        </div>\
                        <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>\
                        <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>\
                        <div class="pswp__caption">\
                            <div class="pswp__caption__center"></div>\
                        </div>\
                    </div>\
                </div>\
            </div>';
        document.querySelector('body').appendChild(photoswipeTemplate.content);
        ssButton = document.querySelector(ssButtonClass);
    }

    /**
     * Open PhotoSwipe
     */
    var openPhotoSwipe = function (pid, gid) {
        var photoswipeContainer = document.querySelectorAll('.pswp')[0];
        var items = [];

        document.querySelectorAll('a.lightbox[rel=' + gid + ']').forEach(el => {
            var caption = '';
            if (el.dataset.lightboxCaption) {
                caption = el.dataset.lightboxCaption;
            } else if (el.nextSibling && el.nextSibling.nodeName == "FIGCAPTION") {
                caption = el.nextSibling.innerText;
            }

            var link = el.parentNode.querySelector('a.button.is-hidden');
            if(link){
                caption = '<div>' + caption + '</div>' + link.outerHTML;
            }

            var title = el.title;

            if (!title && caption) {
                title = '--none--'
            }
            items.push({
                src: el.getAttribute('href'),
                title: title,
                w: el.dataset.lightboxWidth,
                h: el.dataset.lightboxHeight,
                caption: caption.replace(/(?:\r\n|\r|\n)/g, '<br />'),
                pid: Array.prototype.slice.call(document.querySelectorAll('a.lightbox'), 0).indexOf(el),
            });
        });
        var options = {
            index: pid,
            addCaptionHTMLFn: function (item, captionEl) {
                captionEl.children[0].innerHTML = '';
                if (item.title && item.title !== '--none--') {
                    captionEl.children[0].innerHTML += '<div class="pswp__caption__title">' + item.title + '</div>';
                }
                if (item.caption) {
                    captionEl.children[0].innerHTML += '<div class="pswp__caption__subtitle">' + item.caption + '</div>';
                }
                return false;
            },
            spacing: 0.12,
            loop: true,
            bgOpacity: 1,
            closeOnScroll: true,
            history: true,
            galleryUID: gid,
            galleryPIDs: true,
            closeEl: true,
            captionEl: true,
            fullscreenEl: true,
            zoomEl: false,
            shareEl: false,
            counterEl: true,
            arrowEl: true,
            preloaderEl: true,
        };
        if (items.length > 0) {
            gallery = new PhotoSwipe(photoswipeContainer, PhotoSwipeUI_Default, items, options);

            setSlideshowState(ssButton, false /* not running from the start */);

            // start timer for the next slide in slideshow after prior image has loaded
            gallery.listen('afterChange', function () {
                if (ssRunning) {
                    slideshowAnimation = setInterval(frame, ssDelay);
                    function frame(){
                        clearInterval(slideshowAnimation);
                        gotoNextSlide();
                    }
                }
            });
            gallery.listen('destroy', function () {
                gallery = null;
            });

            gallery.init();
        }
    };

    /* slideshow management */
    if(ssButton){
        ssButton.addEventListener('click', el => {
            setSlideshowState(ssButton, !ssRunning);
        });
    }

    function setSlideshowState(el, running) {
        if (running) {
            setTimeout(gotoNextSlide);
        } else {
            clearInterval(slideshowAnimation);
            document.querySelector('.pswp__progress > span').classList.remove('load');
        }
        var title = running ? "Pause Slideshow (Space bar)" : "Play Slideshow (Space bar)";
        el.classList.remove(running ? "play" : "pause");
        el.classList.add(running ? "pause" : "play");
        el.title = title;
        ssRunning = running;
    }

    function gotoNextSlide() {
        if (ssRunning && !!gallery) {
            gallery.next();
            document.querySelector('.pswp__progress > span').classList.add('load');
        }
    }

    /* override handling of Esc key to stop slideshow on first esc (note Esc to leave fullscreen never gets here) */
    document.addEventListener('keydown', (e) => {
        if (e.altKey || e.ctrlKey || e.shiftKey || e.metaKey) return;
        if ((e.key === "Space" || e.which == 32 /*esc*/) && !!gallery) {
            if (e.preventDefault) e.preventDefault();
            else e.returnValue = false;
            setSlideshowState(ssButton, !ssRunning);
        }
        if ((e.key === "Escape" || e.which == 27 /*esc*/) && !!gallery) {
            if (e.preventDefault) e.preventDefault();
            else e.returnValue = false;
            if (ssRunning) {
                setSlideshowState(ssButton, false);
            } else {
                gallery.close();
            }
        }
    });

    /**
     * Get PhotoSwipe params from url hash and open gallery
     */
    var getPhotoSwipeParamsFromHash = function () {
        var hash = window.location.hash.substring(1),
            params = {};
        if (hash.length < 5) {
            return params;
        }
        var vars = hash.split('&');
        for (var i = 0; i < vars.length; i++) {
            if (!vars[i]) {
                continue;
            }
            var pair = vars[i].split('=');
            if (pair.length < 2) {
                continue;
            }
            params[pair[0]] = pair[1];
        }
        return params;
    };
    var photoSwipeHashData = getPhotoSwipeParamsFromHash();
    if (photoSwipeHashData.pid && photoSwipeHashData.gid) {
        openPhotoSwipe(parseInt(photoSwipeHashData.pid), photoSwipeHashData.gid);
    }

    /**
     * Register listener
     */
    document.querySelectorAll('a.lightbox').forEach(el => {
        el.addEventListener('click', (e) => {
            e.preventDefault();
            var gid = el.getAttribute('rel');
            var pid = Array.prototype.slice.call(document.querySelectorAll('a[rel="' + gid + '"]'), 0).indexOf(el);
            openPhotoSwipe(pid, gid);
        });
    });
});
