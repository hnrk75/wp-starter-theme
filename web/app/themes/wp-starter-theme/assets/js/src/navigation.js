/**
 * Theme JavaScript
 */

document.addEventListener('DOMContentLoaded', () => {
  initMobileNav();
  initDropdowns();
});

/**
 * Mobile nav toggle
 */
function initMobileNav() {
  const toggle = document.querySelector('.site-nav__toggle');
  const nav = document.getElementById('main-nav');

  if (!toggle || !nav) return;

  toggle.addEventListener('click', () => {
    const expanded = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!expanded));
    nav.classList.toggle('is-open', !expanded);
  });

  // Close on outside click
  document.addEventListener('click', (e) => {
    if (!nav.contains(e.target) && !toggle.contains(e.target)) {
      toggle.setAttribute('aria-expanded', 'false');
      nav.classList.remove('is-open');
    }
  });
}

/**
 * Dropdown submenus
 */
function initDropdowns() {
  const toggles = document.querySelectorAll('.site-nav__link--parent');

  toggles.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const expanded = btn.getAttribute('aria-expanded') === 'true';

      // Close all other open dropdowns
      toggles.forEach((other) => {
        if (other !== btn) {
          other.setAttribute('aria-expanded', 'false');
          other.closest('.site-nav__item')?.classList.remove('is-open');
        }
      });

      btn.setAttribute('aria-expanded', String(!expanded));
      btn.closest('.site-nav__item')?.classList.toggle('is-open', !expanded);
    });
  });

  // Close dropdowns on outside click
  document.addEventListener('click', () => {
    toggles.forEach((btn) => {
      btn.setAttribute('aria-expanded', 'false');
      btn.closest('.site-nav__item')?.classList.remove('is-open');
    });
  });

  // Close on Escape
  document.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape') return;
    toggles.forEach((btn) => {
      btn.setAttribute('aria-expanded', 'false');
      btn.closest('.site-nav__item')?.classList.remove('is-open');
    });
  });
}
