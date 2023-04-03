
<template>
  <ul :class="$style.list">
    <li
      v-for="(item, idx) in items"
      :key="item.cart_key"
    >
      <woo-product-card
        v-bind="item"
        :is-editable="isEditable"
        @update="onUpdate(idx, $event)"
      />
    </li>
  </ul>
</template>

<style lang="scss" module>
@use '~genero-design-system/src/components/gds-heading' as heading;
@use '~genero-design-system/src/components/gds-paragraph' as paragraph;

.list {
  list-style-type: none;
  padding-left: 0 !important;

  > li:not(:last-child) {
    margin-bottom: var(--gds-spacing-s);
  }
}
</style>

<script lang="js">
import WooProductCard from './WooProductCard.vue';

export default {
  components: {
    WooProductCard,
  },
  emits: ['update'],
  props: {
    cart: { type: Array, required: true },
    isEditable: { type: Boolean, default: false },
  },
  data() {
    return {
      items: [...this.cart],
    }
  },
  methods: {
    onUpdate(itemIdx, quantity) {
      const item = {
        ...this.items[itemIdx],
        quantity
      };

      this.items[itemIdx] = item;
      this.$emit('update', item);
    },
  },
};
</script>
