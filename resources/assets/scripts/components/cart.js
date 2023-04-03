import Cookies from 'js-cookie';

export function isLoggedIn() {
  return Cookies.get('wp_user_logged_in') === '1';
}

export function getCartCount() {
  return parseInt(Cookies.get('wp_user_cart_count') || 0);
}

export async function updateCartCount() {
  console.log('update cart count');

  const response = await fetch('/wp-json/gds/v1/cart/count', {
    credentials: 'same-origin',
  });

  const result = await response.json();
  const count = result?.count || 0;

  if (count > 0) {
    Cookies.set('wp_user_cart_count', count);
  } else {
    Cookies.remove('wp_user_cart_count');
  }

  refreshCartCounter();
}

export function refreshCartCounter() {
  // Set the cart counter value to that of the cookie
  const cartCount = getCartCount();
  for (const el of document.querySelectorAll('[data-menu-cart-counter]')) {
    el.textContent = cartCount ? cartCount : '';
  }
}
