// Babada custom scripts

(function () {
  'use strict';

  const headerSelectors = [
    '.site-header',
    '#masthead',
    '.ast-header',
    '.elementor-location-header',
    '.elementor-section.elementor-location-header'
  ];

  function getHeader() {
    for (const selector of headerSelectors) {
      const el = document.querySelector(selector);
      if (el) return el;
    }
    return null;
  }

  function handleScroll() {
    const header = getHeader();
    if (!header) return;

    const scrollY = window.scrollY || document.documentElement.scrollTop;
    const threshold = 50;

    if (scrollY > threshold) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  }

  function init() {
    const header = getHeader();
    if (!header) return;

    document.body.classList.add('has-transparent-header');

    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
