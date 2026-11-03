import PhotoSwipeLightbox from 'photoswipe/lightbox'
import PhotoSwipe from 'photoswipe'
import { getLabels } from './photoswipe-i18n.js'

const SLIDESHOW_DELAY = 4000 // ms

const ICON_HTML = '<span class="pswp__custom-icn" aria-hidden="true"></span>'

const links = [...document.querySelectorAll('a.lightbox')]

if (links.length > 0) {
  initLightbox(links)
}

function escapeHtml(text) {
  const div = document.createElement('div')
  div.textContent = text
  return div.innerHTML
}

/**
 * Build a PhotoSwipe data item from a link element.
 */
function buildItem(el) {
  const img = el.querySelector('img')

  let caption = el.dataset.lightboxCaption || ''
  if (!caption && el.nextElementSibling?.nodeName === 'FIGCAPTION') {
    caption = el.nextElementSibling.textContent.trim()
  }

  let captionHtml = escapeHtml(caption).replace(/(\r\n|\r|\n)/g, '<br>')

  // Optional hidden button/link shown in the caption
  const button = el.parentNode.querySelector('a.button.is-hidden')
  if (button) {
    captionHtml = `<div>${captionHtml}</div>${button.outerHTML}`
  }

  return {
    src: el.getAttribute('href'),
    width: Number(el.dataset.lightboxWidth) || img?.naturalWidth || 0,
    height: Number(el.dataset.lightboxHeight) || img?.naturalHeight || 0,
    msrc: img?.currentSrc || img?.src, // thumbnail shown while the full image loads
    alt: el.title || img?.alt || '',
    title: el.title || '',
    captionHtml,
    element: el, // used for the opening/closing zoom animation
  }
}

function initLightbox(links) {
  // Group links by their "rel" attribute (one gallery per rel)
  const galleries = new Map()
  links.forEach((el) => {
    const gid = el.getAttribute('rel') || 'gallery'
    if (!galleries.has(gid)) galleries.set(gid, [])
    galleries.get(gid).push(el)
  })
  const galleryItems = new Map(
    [...galleries].map(([gid, els]) => [gid, els.map(buildItem)])
  )

  let currentGid = null
  let ssRunning = false
  let ssTimer = null
  let playButton = null
  let progressBar = null
  let fullscreenButton = null

  const labels = getLabels()

  const lightbox = new PhotoSwipeLightbox({
    pswpModule: PhotoSwipe,
    loop: true,
    spacing: 0.12,
    bgOpacity: 1,
    zoom: false, // hide zoom button (same as zoomEl: false in v4)

    // PhotoSwipe's built-in labels
    closeTitle: labels.close,
    zoomTitle: labels.zoom,
    arrowPrevTitle: labels.arrowPrev,
    arrowNextTitle: labels.arrowNext,
    errorMsg: labels.error,
    indexIndicatorSep: labels.counterSeparator,
  })

  /* ---------- Slideshow ---------- */

  // (Re)start the CSS animation of the progress bar from 0 to 100%
  function startProgress() {
    if (!progressBar) return
    progressBar.classList.remove('is-running')
    void progressBar.offsetWidth // force reflow so the animation restarts
    progressBar.style.setProperty('--ss-delay', `${SLIDESHOW_DELAY}ms`)
    progressBar.classList.add('is-running')
  }

  function stopProgress() {
    progressBar?.classList.remove('is-running')
  }

  function scheduleNext() {
    clearTimeout(ssTimer)
    if (!ssRunning) {
      stopProgress()
      return
    }
    startProgress()
    ssTimer = setTimeout(() => lightbox.pswp?.next(), SLIDESHOW_DELAY)
  }

  function setSlideshow(running) {
    ssRunning = running
    clearTimeout(ssTimer)
    if (!running) stopProgress()
    if (playButton) {
      playButton.dataset.state = running ? 'playing' : 'paused'
      playButton.title = running ? labels.pause : labels.play
      playButton.setAttribute('aria-label', playButton.title)
    }
    if (running) scheduleNext()
  }

  /* ---------- Fullscreen state ---------- */

  function updateFullscreenState() {
    if (!fullscreenButton) return
    const active = !!document.fullscreenElement
    fullscreenButton.dataset.state = active ? 'active' : 'inactive'
    const label = active ? labels.fullscreenExit : labels.fullscreenEnter
    fullscreenButton.title = label
    fullscreenButton.setAttribute('aria-label', label)
  }

  // Also fires when the user leaves fullscreen with the Esc key
  document.addEventListener('fullscreenchange', updateFullscreenState)

  /* ---------- Custom UI elements ---------- */

  lightbox.on('uiRegister', () => {
    const { ui } = lightbox.pswp

    // Play / pause button
    ui.registerElement({
      name: 'playpause',
      order: 8,
      isButton: true,
      html: ICON_HTML,
      title: labels.play,
      ariaLabel: labels.play,
      onInit: (el) => {
        playButton = el
        el.dataset.state = 'paused'
      },
      onClick: () => setSlideshow(!ssRunning),
    })

    // Slideshow progress bar
    ui.registerElement({
      name: 'slideshow-progress',
      order: 10,
      isButton: false,
      appendTo: 'root',
      html: '<span></span>',
      onInit: (el) => {
        progressBar = el
        el.classList.add('pswp__slideshow-progress')
      },
    })

    // Fullscreen button (not built in v5)
    if (document.fullscreenEnabled) {
      ui.registerElement({
        name: 'fullscreen',
        order: 7,
        isButton: true,
        html: ICON_HTML,
        title: labels.fullscreenEnter,
        ariaLabel: labels.fullscreenEnter,
        onInit: (el) => {
          fullscreenButton = el
          updateFullscreenState()
        },
        onClick: (e, el, pswp) => {
          if (document.fullscreenElement) {
            document.exitFullscreen()
          } else {
            pswp.element.requestFullscreen()
          }
        },
      })
    }

    // Caption (title + text)
    ui.registerElement({
      name: 'custom-caption',
      order: 9,
      isButton: false,
      appendTo: 'root',
      html: '',
      onInit: (el, pswp) => {
        el.classList.add('pswp__custom-caption')
        pswp.on('change', () => {
          const { title, captionHtml } = pswp.currSlide.data
          let html = ''
          if (title) html += `<div class="pswp__caption__title">${escapeHtml(title)}</div>`
          if (captionHtml) html += `<div class="pswp__caption__subtitle">${captionHtml}</div>`
          el.innerHTML = html
          el.hidden = !html
        })
      },
    })
  })

  /* ---------- Events ---------- */

  lightbox.on('change', () => {
    // Keep the URL hash in sync (replaces v4's "history" option)
    const index = lightbox.pswp.currIndex + 1
    history.replaceState(
      null,
      '',
      `${location.pathname}${location.search}#gid=${encodeURIComponent(currentGid)}&pid=${index}`
    )
    scheduleNext() // restart the timer after each slide change
  })

  lightbox.on('keydown', (e) => {
    const key = e.originalEvent.key
    if (key === ' ') {
      e.preventDefault()
      setSlideshow(!ssRunning)
    } else if (key === 'Escape' && ssRunning) {
      // First Esc stops the slideshow, second one closes the gallery
      e.preventDefault()
      setSlideshow(false)
    }
  })

  lightbox.on('destroy', () => {
    setSlideshow(false)
    playButton = null
    progressBar = null
    fullscreenButton = null
    currentGid = null
    history.replaceState(null, '', location.pathname + location.search)
  })

  lightbox.init()

  /* ---------- Open helpers ---------- */

  function openGallery(gid, index = 0) {
    const items = galleryItems.get(gid)
    if (!items?.length) return
    currentGid = gid
    const safeIndex = Math.min(Math.max(index, 0), items.length - 1)
    lightbox.loadAndOpen(safeIndex, items)
  }

  // Click on a thumbnail
  galleries.forEach((els, gid) => {
    els.forEach((el, index) => {
      el.addEventListener('click', (e) => {
        e.preventDefault()
        openGallery(gid, index)
      })
    })
  })

  // Open from URL hash: #gid=xxx&pid=2
  const params = new URLSearchParams(location.hash.slice(1))
  const hashGid = params.get('gid')
  const hashPid = parseInt(params.get('pid'), 10)
  if (hashGid && hashPid) {
    openGallery(hashGid, hashPid - 1)
  }
}
