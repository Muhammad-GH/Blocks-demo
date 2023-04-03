<template>
  <form :action="action" method="post" class="woocommerce-layout" ref="form">
    <woo-checkout-progress
      active="cart"
      class="woocommerce-layout__progress-bar"
      :steps="progressBar"
    />

    <div class="woocommerce-layout__main">
      <h1>{{ $i18n('Ostoskori') }}</h1>

      <woo-cart-content
        :is-editable="true"
        :cart="items"
        @update="onUpdate"
      />

      <div :class="$style.coupon">
        <label for="coupon_code">{{ $i18n('Kupongin koodi') }}:</label>
        <input
          type="text"
          name="coupon_code"
          :class="$style.coupon__field"
          id="coupon_code"
          v-model.trim="couponCode"
        >
        <div
          class="wp-block-button  is-style-outline"
          v-if="couponCode.length"
        >
          <input
            type="hidden"
            name="apply_coupon"
            :value="$i18n('Käytä kuponki')"
          />
          <button
            type="submit"
            class="wp-block-button__link"
            @click.prevent="onSubmit"
            :value="$i18n('Käytä kuponki')"
          >
            {{ $i18n('Käytä kuponki') }}
          </button>
        </div>
			</div>
    </div>
    <div class="woocommerce-layout__sidebar">
      <div class="woocommerce-layout__box">
        <table>
          <tbody>
            <tr>
              <th>{{ $i18n('Välisumma') }}:</th>
              <td>
                <span class="total">{{ formatPrice(totalPrice) }}</span>
                <span class="tax">{{ $i18n('sis. alv.') }}&nbsp;{{ formatPrice(totalTax) }}</span>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="woocommerce-layout__box-actions">
          <slot></slot>

          <input
            v-if="isUpdated"
            type="hidden"
            name="update_cart"
            :value="$i18n('Päivitä ostoskori')"
          />
          <button
            v-if="isUpdated"
            type="submit"
            class="wp-block-button__link is-style-outline"
            @click.prevent="onSubmit"
            :value="$i18n('Päivitä ostoskori')"
          >
            {{ $i18n('Päivitä ostoskori') }}
          </button>

          <a
            v-if="!isUpdated"
            class="wp-block-button__link is-style-outline"
            :href="checkoutUrl"
          >
            {{ $i18n('Siirry kassalle') }}
            &nbsp;
            <i class="far fa-chevron-right"></i>
          </a>
        </div>
      </div>
    </div>
  </form>
</template>

<style lang="scss" module>
.coupon {
  border-top: solid 1px var(--gds-color-black-15);
  padding-top: var(--gds-spacing-m);
  margin-top: var(--gds-spacing-m);

  &__field {
    max-width: 380px;
    min-width: auto;
    margin-bottom: var(--gds-spacing-s);
  }
}
</style>

<script lang="js">
import WooCheckoutProgress from './WooCheckoutProgress.vue';
import WooCartContent from './WooCartContent.vue';
import {formatPrice} from '../utils';

export default {
  components: {
    WooCheckoutProgress,
    WooCartContent,
  },
  props: {
    taxRate: { type: Number, required: true },
    action: { type: String, required: true },
    checkoutUrl: { type: String, required: true },
    cart: { type: Array, required: true },
    progressBar: { type: Object, required: true },
  },
  data() {
    return {
      items: [...this.cart],
      couponCode: '',
    }
  },
  computed: {
    totalPrice() {
      return this.items.reduce((carry, item) => {
        return carry + (item.quantity * item.price);
      }, 0);
    },
    totalTax() {
      return this.totalPrice - (this.totalPrice / (this.taxRate + 100) * 100);
    },
    isUpdated() {
      if (this.cart.length !== this.items.length) {
        return true;
      }
      return !this.items.every((item, idx) => item.quantity === this.cart[idx].quantity);
    },
  },
  methods: {
    formatPrice,
    onUpdate(updatedItem) {
      const itemIdx = this.items.findIndex((item) => item.cart_key === updatedItem.cart_key);
      this.items[itemIdx] = updatedItem;
    },
    onSubmit() {
      this.$refs.form.submit();
    }
  },
};
</script>
