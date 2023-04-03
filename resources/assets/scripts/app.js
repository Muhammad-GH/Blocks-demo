import barba from '@barba/core';
import vue from './vue';
import debounce from 'lodash-es/debounce';
import productSlideshow from './components/product-slideshow';
import createTabs from './components/termTabs';
import {
  useLoginStates,
  useHamburgerIcon,
  useCartCounter,
  useMegaMenu,
  useSearchFocus,
  closeMegaMenu,
  closeHamburgerMenu,
} from './components/header';
import createDepartmentFilters from './components/department-filters';
import SimpleLightbox from "simplelightbox";

function setupDomTasks() {
  vue(document.querySelectorAll('[data-vue-wrapper]'));

  for (const el of document.querySelectorAll('.term-tree-tabs')) {
    createTabs(el);
  }

  for (const el of document.querySelectorAll('[data-department-filters]')) {
    createDepartmentFilters(el);
  }

  productSlideshow(document.querySelector('.product-slideshow'));

  new SimpleLightbox('a.lightbox-trigger', { /* options */ });

  // Support for woocommerce sorting select boxes
  for (const el of document.querySelectorAll('.woocommerce-ordering select')) {
    el.addEventListener('change', (e) => e.target.closest('form').submit());
  }
}

setupDomTasks();
useHamburgerIcon();
useLoginStates();
useMegaMenu();
useSearchFocus();
useCartCounter();

// Use barba for PJAX effect as long as admin bar isnt used.
if (!document.body.classList.contains('admin-bar')) {
  barba.init({
    timeout: 5000,
    // @see https://github.com/barbajs/barba/issues/475
    debug: true,
    prevent: ({el}) => {
      if (/\/(wp|checkout|cart|customer-logout)\//.test(el.href || '')) {
        return true;
      }
      if (el.classList.contains('no-barba')) {
        return true;
      }
    },
    transitions: [{
      leave(data) {
        data.current.container.parentNode.classList.remove('barba-enter');
        data.current.container.parentNode.classList.add('barba-leave');
      },
      enter(data) {
        data.current.container.parentNode.classList.remove('barba-leave');
        data.current.container.parentNode.classList.add('barba-enter');

        // Prevent dynamic pages from being cached.
        const url = data.current.url.href;
        if (/\/(cart|checkout|my-account)\//.test(url)) {
          barba.cache.delete(url);
        }
      },
    }],
  });

  barba.hooks.beforeEnter(() => setupDomTasks());
  barba.hooks.after(() => {
    window.ga?.('set', 'page', window.location.pathname);
    window.ga?.('send', 'pageview');
  });
  barba.hooks.beforeLeave((data) => {
    window.scrollTo({ top: 0, behavior: 'smooth' })
    closeMegaMenu();
    closeHamburgerMenu();

    // Remove all menu items with an active state.
    const navigation = document.querySelector('gds-navigation .gds-navigation-content');
    for (const el of navigation.querySelectorAll('.active')) {
      el.classList.remove('active');
    }

    // Mark the current menu item as active.
    navigation.querySelector(`a[href="${data.next.url.href}"]`)?.classList?.add('active');
  });
}

// Set the actual viewport height without toolbars for mobile navigation.
const appHeight = () => {
  const doc = document.documentElement;
  const nav = document.querySelector('.gds-navigation-header');
  doc.style.setProperty('--app-height', `${window.innerHeight}px`)

  if (nav) {
    doc.style.setProperty('--navigation-height', `${nav.offsetHeight}px`)
  } else {
    // In case the navigation hasnt initialized yet.
    window.requestAnimationFrame(() => appHeight());
  }
};

window.addEventListener('resize', debounce(appHeight, 150));
new ResizeObserver(() => appHeight()).observe(document.querySelector('gds-navigation'));
appHeight();

jQuery(document.body).on('click',".archive-filter--sort .filter--text",function () {
  var order_params = '';
  if(jQuery(this).hasClass('order_desc')){
    order_params = '&orderby=asc';
  }else{
    order_params = '&orderby=desc';
  }
  window.location.search = order_params;
});