/**
 * Labels used by the lightbox.
 *
 * Resolution order (later wins):
 *   1. English defaults
 *   2. Built-in translation matching <html lang="..."> (e.g. "fr-FR" -> "fr")
 *   3. Overrides from <script type="application/json" id="photoswipe-labels">
 */

export const translations = {
  en: {
    close: 'Close',
    arrowPrev: 'Previous',
    arrowNext: 'Next',
    zoom: 'Zoom in/out',
    error: 'The image cannot be loaded',
    counterSeparator: ' / ',
    play: 'Play slideshow (Space bar)',
    pause: 'Pause slideshow (Space bar)',
    fullscreenEnter: 'Enter fullscreen',
    fullscreenExit: 'Exit fullscreen',
  },
  fr: {
    close: 'Fermer',
    arrowPrev: 'Précédent',
    arrowNext: 'Suivant',
    zoom: 'Zoom avant/arrière',
    error: 'L’image n’a pas pu être chargée',
    play: 'Lancer le diaporama (barre d’espace)',
    pause: 'Mettre le diaporama en pause (barre d’espace)',
    fullscreenEnter: 'Passer en plein écran',
    fullscreenExit: 'Quitter le plein écran',
  },
  de: {
    close: 'Schließen',
    arrowPrev: 'Zurück',
    arrowNext: 'Weiter',
    zoom: 'Vergrößern/Verkleinern',
    error: 'Das Bild konnte nicht geladen werden',
    play: 'Diashow starten (Leertaste)',
    pause: 'Diashow pausieren (Leertaste)',
    fullscreenEnter: 'Vollbild',
    fullscreenExit: 'Vollbild beenden',
  },
}

function readOverrides() {
  const script = document.getElementById('photoswipe-labels')
  if (!script) return {}
  try {
    return JSON.parse(script.textContent)
  } catch (error) {
    console.warn('photoswipe: invalid JSON in #photoswipe-labels', error)
    return {}
  }
}

export function getLabels(lang = document.documentElement.lang) {
  const code = (lang || 'en').toLowerCase().split('-')[0]
  return {
    ...translations.en,
    ...(translations[code] || {}),
    ...readOverrides(),
  }
}
