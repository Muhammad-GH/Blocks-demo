<template>
  <gds-card :class="[
    $style.container,
  ]">
    <div v-if="thumbnail" :class="$style.thumbnail" v-html="thumbnail"></div>
    <div :class="$style.meta">
      <h6 :class="$style.title">
        <a :href="permalink" v-if="permalink">
          {{title}}
        </a>
      </h6>
      <p :class="$style.description" v-if="description">{{description}}</p>
      <ul :class="$style.attributes">
        <li v-if="pack_size">
          <span :class="$style.attribute__label">{{ $i18n('Pakkauskoko') }}:</span>
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

    </div>
    <div :class="$style.pricing" v-if="price">
      <p :class="$style.price">{{ formatPrice(price) }} / {{ $i18n('kpl') }}</p>
      <p :class="$style.tax">{{ tax }}</p>

      <div v-if="isEditable" :class="$style.actions">
        <input-quantity
          :class="$style.quantity_input"
          min="0"
          :max="max_quantity"
          step="1"
          :name="quantityInputName"
          v-model.number="newQuantity"
        />
        <a
          :href="removeUrl"
        >
          <i class="fal fa-trash fa-lg" title="Remove"></i>
        </a>
      </div>
      <div v-else :class="$style.quantity_text">
        {{ newQuantity }}&nbsp;{{ $i18n('kpl') }}
      </div>

      <p :class="$style.subtotal">{{ $i18n('Yht.') }}&nbsp;{{ formatPrice(subtotal) }}</p>
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
    "thumbnail meta"
    "thumbnail pricing";
  grid-template-columns: auto 1fr;
  column-gap: var(--gds-spacing-s);

  @include mq($from: large) {
    grid-gap: var(--gds-spacing-s);
    grid-template-areas: "thumbnail meta pricing";
    grid-template-columns: auto 1fr auto;
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

.thumbnail {
  grid-area: thumbnail;

  img {
    max-width: clamp(50px, 20vw, 120px);
    max-height: clamp(50px, 20vw, 120px);
    object-fit: contain;
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

  @include mq($from: large) {
    margin-top: 0;
    display: block;
    text-align: right;
  }
}

.price {
  @include heading.size-xs;

  margin-right: var(--gds-spacing-xs);

  @include mq($from: large) {
    margin-right: 0;
  }
}

.quantity_text {
  @include heading.size-xs;

  margin-top: var(--gds-spacing-s);
  flex: 1 0 auto;
}

.tax {
  font-weight: 300;
  color: var(--gds-color-black-60);
  margin-top: 0;
  flex: 1 0 auto;
}

@include mq($until: large) {
  .pricing {
    column-gap: var(--gds-spacing-xs);

    > p {
      margin-top: 0;
      margin-bottom: 0;
      line-height: var(--gds-heading-xs-line-height);
    }
  }

  // Let tax cause a line wrap so quantity and total price is on a new line
  .tax {
    flex: 1 0 100%;
  }

  // Let quantity push total price to the right
  .quantity_text {
    flex: 1 0 auto;
  }
}

.subtotal {
  @include heading.size-s;

  margin-top: var(--gds-spacing-s) !important; // override default paragraph style
  color: var(--gds-color-ui-02);
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
  align-items: center;
  grid-gap: var(--gds-spacing-s);
  grid-template-columns: max-content max-content;
  width: 100%;
  margin-top: var(--gds-spacing-s);
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
  },
  emits: ['update'],
  props: {
    sku: { type: String, required: true },
    title: { type: String, required: true },
    description: { type: String, required: false },
    price: { type: Number, required: true },
    quantity: { type: Number, required: true },
    max_quantity: { type: Number, default: null },
    attributes: { type: Object, required: true },
    tax: { type: String, required: true },
    cart_key: { type: String, required: true },
    thumbnail: { type: String, default: null },
    permalink: { type: String, default: null },
    remove_url: { type: String, default: null },
    isEditable: { type: Boolean, default: false },
  },
  computed: {
    subtotal() {
      return this.newQuantity * this.price;
    },
    removeUrl() {
      return this.remove_url.replace('&amp;', '&');
    },
    quantityInputName() {
      return `cart[${this.cart_key}][qty]`
    },
  },
  watch: {
    newQuantity(quantity) {
      if (quantity !== this.quantity) {
        this.$emit('update', quantity);
      }
    },
  },
  data() {
    return {
      newQuantity: this.quantity,
    }
  },
  methods: {
    formatPrice,
  }
};
</script>
