{{--
Thankyou page

This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see https://docs.woocommerce.com/document/template-structure/
@package WooCommerce\Templates
@version 3.7.0
--}}

@php(defined('ABSPATH' ) || exit)

<div class="woocommerce-order woocommerce-layout">
  <div class="woocommerce-layout__progress-bar" data-vue-wrapper>
    <woo-checkout-progress
      active="confirmation"
      :steps='{!! json_encode($progress_steps) !!}'
    ></woo-checkout-progress>
  </div>

  <div class="woocommerce-layout__main">
    @if ($order)
      @php(do_action('woocommerce_before_thankyou', $order->get_id()))

      @if ($order->has_status('failed'))
        <h1 class="woocommerce-thankyou-order-failed">
          {{ __('Tilaus epäonnistui') }}
        </h1>

        <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed">
          {{ __('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce') }}
        </p>

        <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
          <a href="{!! esc_url($order->get_checkout_payment_url()) !!}" class="button pay">
            {!! esc_html_e('Pay', 'woocommerce') !!}
          </a>
          @if (is_user_logged_in())
            <a href="{!! esc_url(wc_get_page_permalink('myaccount')) !!}" class="button pay">
              {!! esc_html_e('My account', 'woocommerce') !!}
            </a>
          @endif
        </p>

      @else
        <h1 class="woocommerce-thankyou-order-received">
          {!! apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'woocommerce'), $order) !!}
        </h1>

        <p>{{ __('Tilausvahvistus on lähetetty sähköpostiisi.', 'gds') }}</p>

        <h2>{{ __('Yhteenveto', 'gds') }}</h2>

        <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
          <li class="woocommerce-order-overview__order order">
            {!! esc_html_e('Order number:', 'woocommerce') !!}
            <strong>{!! $order->get_order_number() !!}</strong>
          </li>

          <li class="woocommerce-order-overview__date date">
            {!! esc_html_e('Date:', 'woocommerce') !!}
            <strong>{!! wc_format_datetime($order->get_date_created()); !!}</strong>
          </li>

          @if (is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email())
            <li class="woocommerce-order-overview__email email">
              {!! esc_html_e('Email:', 'woocommerce') !!}
              <strong>{!! $order->get_billing_email() !!}</strong>
            </li>
          @endif

          <li class="woocommerce-order-overview__total total">
            {!! esc_html_e('Total:', 'woocommerce') !!}
            <strong>{!! $order->get_formatted_order_total() !!}</strong>
          </li>

          @if ($order->get_payment_method_title())
            <li class="woocommerce-order-overview__payment-method method">
              {!! esc_html_e('Payment method:', 'woocommerce') !!}
              <strong>{!! wp_kses_post($order->get_payment_method_title()) !!}</strong>
            </li>
          @endif

        </ul>

      @endif

      @php(do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()))
      @php(do_action('woocommerce_thankyou', $order->get_id()))

    @else
      <h1 class="woocommerce-thankyou-order-received">
        {!! apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'woocommerce'), $order) !!}
      </h1>
    @endif
  </div>
  <div class="woocommerce-layout__sidebar"></div>
</div>
