{{--
Cart Page

This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see     https://docs.woocommerce.com/document/template-structure/
@package WooCommerce\Templates
@version 3.8.0
--}}

@php defined('ABSPATH') || exit; @endphp

@php do_action('woocommerce_before_cart'); @endphp

<div class="woocommerce-cart-form" data-vue-wrapper>
  <woo-cart-form
    action="{!! esc_url($cart_url) !!}"
    checkout-url="{!! esc_url($checkout_url) !!}"
    :progress-bar='{!! json_encode($progress_steps) !!}'
    :tax-rate="24.0" {{-- @TODO --}}
    :i18n='{!! json_encode([
      'Tuotenumero' => __('Tuotenumero', 'gds'),
      'kpl' => __('kpl', 'gds')
    ]) !!}'
    :cart='@json($cart)'
    v-cloak
    class="has-spinner"
  >
    @php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce') @endphp
  </woo-cart-form>
</div>
