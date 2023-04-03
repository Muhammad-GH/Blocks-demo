<?php
// phpcs:disable PSR2.Methods.FunctionCallSignature,PSR12.ControlStructures.ControlStructureSpacing,Squiz.WhiteSpace.ControlStructureSpacing.SpacingAfterOpen,Generic.WhiteSpace.ScopeIndent
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<table class="shop_table woocommerce-checkout-review-order-table">
  <tbody>

    <tr class="cart-subtotal">
      <th><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
      <td><?php wc_cart_totals_subtotal_html(); ?></td>
    </tr>

    <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
      <tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
        <th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
        <td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
      </tr>
    <?php endforeach; ?>

    <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

      <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

      <?php wc_cart_totals_shipping_html(); ?>

      <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

    <?php endif; ?>

    <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
      <tr class="fee">
        <th><?php echo esc_html( $fee->name ); ?></th>
        <td><?php wc_cart_totals_fee_html( $fee ); ?></td>
      </tr>
    <?php endforeach; ?>

    <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
      <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
        <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
          <tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
            <th><?php echo esc_html( $tax->label ); ?></th>
            <td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else : ?>
        <tr class="tax-total">
          <th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
          <td><?php wc_cart_totals_taxes_total_html(); ?></td>
        </tr>
      <?php endif; ?>
    <?php endif; ?>

    <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

    <tr class="order-total">
      <th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
      <td>
        <?php //wc_cart_totals_order_total_html(); ?>
        <span class="total">{!! WC()->cart->get_total() !!}</span>
        @php
          $cart_tax_totals  = WC()->cart->get_tax_totals();
          $tax_string_array[] = sprintf('%s %s', wc_price(WC()->cart->get_taxes_total(true, true)), WC()->countries->tax_or_vat());

          if (!empty($tax_string_array)) {
            $taxable_address = WC()->customer->get_taxable_address();

            if (WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()) {
              $country = WC()->countries->estimated_for_prefix($taxable_address[0]) . WC()->countries->countries[$taxable_address[0]];
              /* translators: 1: tax amount 2: country name */
              $tax_text = wp_kses_post(sprintf(__('includes %1$s estimated for %2$s', 'woocommerce'), implode(', ', $tax_string_array), $country));
            } else {
              /* translators: %s: tax amount */
              $tax_text = wp_kses_post( sprintf(__('includes %s', 'woocommerce'), implode(', ', $tax_string_array)));
            }
          }
        @endphp
        <span class="tax">{!! $tax_text !!}</span>
      </td>
    </tr>

    <?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

  </tbody>
</table>
