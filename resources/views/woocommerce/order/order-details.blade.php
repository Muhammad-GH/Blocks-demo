<?php
// phpcs:disable PSR2.Methods.FunctionCallSignature,PSR12.ControlStructures.ControlStructureSpacing,Squiz.WhiteSpace.ControlStructureSpacing.SpacingAfterOpen,Generic.WhiteSpace.ScopeIndent
?>
{{--
Order details

This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see     https://docs.woocommerce.com/document/template-structure/
@package WooCommerce\Templates
@version 4.6.0
--}}

@php defined('ABSPATH') || exit; @endphp

@php
  $order = wc_get_order($order_id); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
  if (!$order) {
    return;
  }

  $order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
  $show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
  $show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
  $downloads             = $order->get_downloadable_items();
  $show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

  if ( $show_downloads ) {
    wc_get_template(
      'order/order-downloads.php',
      array(
        'downloads'  => $downloads,
        'show_title' => true,
      )
    );
  }
@endphp

<section class="woocommerce-order-details">
  <?php do_action('woocommerce_order_details_before_order_table', $order); ?>

  <h2 class="woocommerce-order-details__title"><?php esc_html_e( 'Order details', 'woocommerce' ); ?></h2>

  <div data-vue-wrapper>
    <woo-cart-content
      :is-editable="false"
      :cart='@json($cart)'
      v-cloak
      class="has-spinner"
    >
    </woo-cart-content>
  </div>

  <div class="woocommerce-layout__box">
    <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
      <tbody>
        @foreach ($order->get_order_item_totals() as $key => $total)
          <tr>
            <th scope="row"><?php echo esc_html( $total['label'] ); ?></th>
            <td><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : wp_kses_post( $total['value'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
          </tr>
        @endforeach
        @if ($order->get_customer_note())
          <tr>
            <th><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
            <td><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>

  @php(do_action('woocommerce_order_details_after_order_table', $order))
</section>

@php(do_action('woocommerce_after_order_details', $order))

@if ($show_customer_details)
  @php(wc_get_template('order/order-details-customer.php', ['order' => $order]))
@endif
