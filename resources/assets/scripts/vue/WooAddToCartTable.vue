<template>
  <div>
    <ul :class="$style.list">
      <li
        v-for="variation in variations"
        :key="variation.id"
      >
        <woo-product-variation
          v-bind="variation"
          :variation="variation"
        />
      </li>
    </ul>
  </div>
</template>

<style lang="scss" module>
.list {
  list-style-type: none;
  padding-left: 0 !important;

  > li:not(:last-child) {
    margin-bottom: var(--gds-spacing-s);
  }
}
</style>

<script lang="js">
import WooProductVariation from './WooProductVariation.vue';

export default {
  components: {
    WooProductVariation,
  },
  props: {
    variations: { type: Array, required: true }
  },
};
</script>
