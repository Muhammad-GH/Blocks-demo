import { isLoggedIn, updateCartCount, refreshCartCounter } from './cart';

// Toggle logged-in/out conditional elements.
export function useLoginStates() {
  const whenLoggedOut = document.querySelectorAll('[data-when-logged-out]')
  const whenLoggedIn = document.querySelectorAll('[data-when-logged-in]')
  if (isLoggedIn()) {
    whenLoggedOut.forEach((el) => el.remove());
  } else {
    whenLoggedIn.forEach((el) => el.remove());
    whenLoggedOut.forEach((el) => el.classList.remove('is-hidden'));
  }
}

// Toggle the hamburger icon
export function useHamburgerIcon() {
  const navigation = document.querySelector('gds-navigation');
  const hamburgerButton = document.querySelector('gds-hamburger')
  navigation?.addEventListener('openHamburgerMenu', () => hamburgerButton.active = true);
  navigation?.addEventListener('closeHamburgerMenu', () => hamburgerButton.active = false);
}

export function closeMegaMenu() {
  for (const el of document.querySelectorAll('gds-menu-item-nested[expanded], gds-menu-item-nested.is-megamenu-open')) {
    el.removeAttribute('expanded');
    el.classList.remove('is-megamenu-open');
  }
}

export function openHamburgerMenu() {
  document.querySelector('gds-navigation')
    .dispatchEvent(new CustomEvent('openHamburgerMenu'));
}

export function closeHamburgerMenu() {
  document.querySelector('gds-navigation')
    .dispatchEvent(new CustomEvent('closeHamburgerMenu'));
}


export function useCartCounter() {
  // Listen to AJAX driven add to cart events
  window.jQuery?.(document.body).on('added_to_cart updated_wc_div', () => updateCartCount());
  // Set the cart counter value to that of the cookie
  refreshCartCounter();
}

export function useMegaMenu() {
  const desktopMenuMedia = window.matchMedia('(min-width: 1024px)');
  // Megamenu close buttons
  const megamenuCloseButtons = document.querySelectorAll('[data-megamenu-close]');
  for (const button of megamenuCloseButtons) {
    button.addEventListener('click', (event) => {
      const menuItem = event.target.closest('gds-menu-item-nested');
      menuItem.dispatchEvent(new CustomEvent('close'));
    });
  }

  // Megamenu triggers
  const megamenuButtons = document.querySelectorAll('gds-menu-item-nested');
  for (const button of megamenuButtons) {
    button.addEventListener('click', (event) => {
      if (!desktopMenuMedia.matches) {
        return;
      }
      if (button.querySelector('.megamenu').contains(event.target)) {
        return;
      }

      // Close all other mega menus
      if (!button.classList.contains('is-megamenu-open')) {
        closeMegaMenu();
      }

      event.preventDefault();
      event.stopImmediatePropagation();
      button.classList.toggle('is-megamenu-open');
    })
  }
}

export function useSearchFocus() {
  const searchFocusButton = document.querySelector('[data-search-focus-button]');
  searchFocusButton?.addEventListener('click', () => {
    openHamburgerMenu();

    requestAnimationFrame(() => {
      document.querySelector('gds-navigation .header-search--mobile input').focus();
    });
  });
}
