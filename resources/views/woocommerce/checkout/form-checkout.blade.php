{{--
Checkout Form

This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see https://docs.woocommerce.com/document/template-structure/
@package WooCommerce\Templates
@version 3.5.0
--}}

@if (!defined('ABSPATH'))
  @return
@endif

{{-- If checkout registration is disabled and not logged in, the user cannot checkout. --}}
@if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in())
  {!! esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce'))) !!}
  @return
@endif

<form name="checkout" method="post" class="checkout woocommerce-checkout woocommerce-layout" action="{{ wc_get_checkout_url() }}" enctype="multipart/form-data">
  <div class="woocommerce-layout__progress-bar" data-vue-wrapper>
    <woo-checkout-progress
      active="checkout"
      :steps='{!! json_encode($progress_steps) !!}'
    ></woo-checkout-progress>
  </div>
  <div class="woocommerce-layout__main">
    <h1>{{ get_the_title() }} </h1>
    @php(do_action('woocommerce_before_checkout_form', $checkout))

    @if ($checkout->get_checkout_fields())
      @php(do_action('woocommerce_checkout_before_customer_details'))

      <div class="col2-set" id="customer_details">
        <div class="col-1">
          @php(do_action('woocommerce_checkout_billing'))
        </div>

        <div class="col-2">
          @php(do_action('woocommerce_checkout_shipping'))
        </div>
      </div>

      @php(do_action('woocommerce_checkout_after_customer_details'))

    @endif

    @php(do_action('woocommerce_checkout_before_order_review_heading'))

    <h2 id="order_payment_heading">{{ __('Valitse maksutapa', 'gds') }}</h3>

    @php(woocommerce_checkout_payment())

		@php(wc_get_template('checkout/terms.php'))

    <h2 id="order_review_heading">{{ esc_html_e('Your order', 'woocommerce') }}</h3>

    @php(do_action('woocommerce_checkout_before_order_review'))
    @php(do_action('woocommerce_checkout_after_order_review'))
    @php(do_action('woocommerce_after_checkout_form', $checkout))


    <div data-vue-wrapper>
      <woo-cart-content
        :is-editable="false"
        :cart='@json($cart)'
        v-cloak
        class="has-spinner"
      >
      </woo-cart-content>

    </div>
  </div>

  <div class="woocommerce-layout__sidebar">
    <div class="woocommerce-layout__box">
      <div id="order_review" class="woocommerce-checkout-review-order">
        @php(do_action('woocommerce_checkout_order_review'))
      </div>

      <div class="form-row place-order">
        {{-- Originally in payment.blade.php --}}
        <noscript>
          {!! sprintf(esc_html__('Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce'), '<em>', '</em>') !!}
          <br/>
          <button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="{{ esc_attr_e('Update totals', 'woocommerce') }}">
            {{ esc_html_e('Update totals', 'woocommerce') }}
          </button>
        </noscript>

        @php(do_action('woocommerce_review_order_before_submit'))

        @php($order_button_text = apply_filters('woocommerce_order_button_text', __('Place order', 'woocommerce')))

        <div class="woocommerce-layout__box-actions">
          {!! apply_filters(
            'woocommerce_order_button_html',
            '<button type="submit" class="button wp-block-button wp-block-button__link is-style-outline" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr($order_button_text) . '" data-value="' . esc_attr($order_button_text) . '">' . esc_html($order_button_text) . '</button>'
          ) !!}
        </div>

        @php(do_action('woocommerce_review_order_after_submit'))

        {!! wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ) !!}
      </div>
    </div>
  </div>
</form>

