<template>
  <gds-card :class="[
    $style.container,
    stock_status === 'instock' ? `${$style.is_instock}` : '',
    stock_status === 'outofstock' ? `${$style.is_outofstock}` : '',
    stock_status === 'onbackorder' ? `${$style.is_onbackorder}` : '',
  ]">
    <div :class="$style.meta">
      <h6 :class="$style.title">{{title}}</h6>
      <p :class="$style.description" v-if="description">{{description}}</p>
      <ul :class="$style.attributes">
        <li v-if="pack_size">
          <span :class="$style.attribute__label">Pakkauskoko:</span>
          <span :class="$style.attribute__value">{{ pack_size }}</span>
        </li>
        <li v-if="sku">
          <span :class="$style.attribute__label">{{ $i18n('Tuotenumero') }}:</span>
          <span :class="$style.attribute__value">{{ sku }}</span>
        </li>
        <li
          v-for="(attribute, label) in attributes"
          :key="label"
        >
          <span :class="$style.attribute__label">{{ label }}:</span>
          <span :class="$style.attribute__value">{{ attribute }}</span>
        </li>
      </ul>

      <p :class="$style.stock_message" v-if="price">
        {{ stock_message }}
      </p>
    </div>
    <div :class="$style.pricing" v-if="price">
      <p :class="$style.price">{{ formatPrice(price) }}</p>
      <p :class="$style.tax">{{ tax }}</p>

      <div v-if="isInStock" :class="$style.actions">
        <input-quantity
          :class="$style.quantity"
          min="1"
          :max="max_quantity"
          step="1"
          v-model.number="quantity"
        />

        <woo-add-to-cart-button
          :disabled="!quantity || isLocked"
          :id="product_id"
          :variation-id="id !== product_id ? id : null"
          :quantity="quantity"
          @completed="quantity = 1"
        />
      </div>
    </div>
  </gds-card>
</template>

<style lang="scss" module>
@use '@/common/breakpoints' as *;
@use '~genero-design-system/src/components/gds-heading' as heading;
@use '~genero-design-system/src/components/gds-paragraph' as paragraph;
@use '~genero-design-system/src/components/gds-card' as card;
@use '~genero-design-system/src/components/gds-media-card' as media-card;
@use '~genero-design-system/src/components/gds-button' as button;

.container {
  --gds-card-max-width: none;
  --gds-card-width: auto;

  padding: var(--gds-media-card-content-padding);
  text-align: left;
  font-size: 14px;
  display: grid;
  grid-template-areas:
    "meta"
    "pricing";

  @include mq($from: large) {
    grid-gap: var(--gds-spacing-s);
    grid-template-areas: "meta pricing";
    grid-template-columns: 1fr auto;
  }

  p {
    margin-top: var(--gds-media-card-paragraph-gutter);
    margin-bottom: var(--gds-media-card-paragraph-gutter);

    &:first-child {
      margin-top: 0;
    }

    &:last-child {
      margin-bottom: 0;
    }
  }
}

.meta {
  grid-area: meta;
}

.pricing {
  grid-area: pricing;
  display: flex;
  flex-wrap: wrap;
  align-items: flex-end;
  margin-top: var(--gds-spacing-2xs);

  @include mq($until: large) {
    > p {
      margin-top: 0;
      margin-bottom: 0;
    }
  }

  @include mq($from: large) {
    margin-top: 0;
    display: block;
    text-align: right;
  }
}

.price {
  @include heading.size-m;

  color: var(--gds-color-ui-02);
  margin-right: var(--gds-spacing-xs);

  @include mq($from: large) {
    margin-right: 0;
  }

  .is_outofstock & {
    color: var(--gds-color-black-60);
  }
}

.tax {
  font-weight: 300;
  color: var(--gds-color-black-60);
  margin-top: 0;
  flex: 1 0 auto;
}

.title {
  .is_outofstock & {
    color: var(--gds-color-black-60);
  }
}

.attributes {
  list-style-type: none;
  padding-left: 0 !important;
  margin-top: var(--gds-spacing-3xs);
  margin-bottom: var(--gds-spacing-3xs);
  line-height: 18px;

  @include mq($from: large) {
    margin-top: var(--gds-spacing-2xs);
    margin-bottom: var(--gds-spacing-2xs);
  }

  > li {
    margin-top: 0 !important;
  }
}

.attribute__label {
  font-weight: 500;
  margin-right: 1ch;
}

.actions {
  display: grid;
  grid-gap: var(--gds-spacing-s);
  grid-template-columns: max-content max-content;
  width: 100%;
  margin-top: var(--gds-spacing-s);

  @include mq($from: large) {
    margin-top: var(--gds-spacing-m);
  }
}

.stock_message {
  font-weight: 500;

  .is_onbackorder &,
  .is_instock & {
    color: var(--gds-color-success);
  }

  .is_outofstock & {
    color: var(--gds-color-error);
  }
}
</style>

<script lang="js">
import InputQuantity from './InputQuantity.vue';
import WooAddToCartButton from './WooAddToCartButton.vue';
import {formatPrice} from '../utils';
import {mapState} from 'vuex'

export default {
  components: {
    InputQuantity,
    WooAddToCartButton,
  },
  emits: ['update'],
  props: {
    is_variation: { type: Boolean, required: true },
    id: { type: Number, required: true },
    product_id: { type: Number, required: true },
    sku: { type: String, required: true },
    title: { type: String, required: true },
    description: { type: String, required: false },
    pack_size: { type: String, required: false },
    price: { type: Number, required: true },
    max_quantity: { type: Number, default: 10000 },
    attributes: { type: Object, required: true },
    regular_price: { type: Number, required: false },
    stock_status: { type: String, required: true },
    stock_message: { type: String, required: true },
    tax: { type: String, required: true },
    variation: { type: Object, required: true },
  },
  computed: {
    ...mapState([
      'isLocked',
    ]),
    isInStock() {
      return this.stock_status === 'instock' || this.stock_status === 'onbackorder';
    },
  },
  data() {
    return {
      quantity: 1,
    };
  },
  methods: {
    formatPrice,
  }
};
</script>
