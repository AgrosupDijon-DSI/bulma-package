// Get all "scroll-top" elements
const scrollTopElements = document.querySelectorAll('.scroll-top');

// Check if there are any "scroll-top" elements
if (scrollTopElements.length > 0) {

  // Hide & Show .scroll-top link on scroll
  window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
      scrollTopElements.forEach(el => {
        if (!el.classList.contains('scroll-top-visible')) {
          el.classList.add('scroll-top-visible');
        }
      });
    } else {
      scrollTopElements.forEach(el => {
        if (el.classList.contains('scroll-top-visible')) {
          el.classList.remove('scroll-top-visible');
        }
      });
    }
  });
}
