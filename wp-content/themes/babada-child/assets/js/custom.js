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

    console.log('[babada-header] scrollY:', scrollY, 'threshold:', threshold, 'header:', header.id || header.className);

    if (scrollY > threshold) {
      header.classList.add('scrolled');
      console.log('[babada-header] added .scrolled');
    } else {
      header.classList.remove('scrolled');
      console.log('[babada-header] removed .scrolled');
    }
  }

  function init() {
    const header = getHeader();
    if (!header) return;

    console.log('[babada-header] init, found header:', header.id || header.className);

    document.body.classList.add('has-transparent-header');
    document.body.classList.add('babada-header-js-loaded');

    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
