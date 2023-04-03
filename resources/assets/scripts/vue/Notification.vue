<template>
  <gds-card :class="[
    $style.notice,
    isError ? $style.is_error : '',
  ]">
    <button
      :class="$style.close"
      @click="close"
    >x</button>
    <slot />
  </gds-card>
</template>

<style lang="scss" module>
@use '@/common/breakpoints' as *;

.notice {
  --gds-card-width: 100%;
  --gds-card-border: solid 2px var(--gds-color-ui-02);

  position: fixed;
  top: var(--gds-spacing-3xl);
  padding: var(--gds-media-card-content-padding);
  text-align: left;
  font-size: 14px;
  z-index: 1000;
  overflow: visible;
  left: 0;
  right: 0;

  @include mq($from: small) {
    --gds-card-max-width: 282px;

    left: auto;
    right: var(--gds-spacing-xl);
  }

  &.is_error {
    border-color: var(--gds-color-error);
    // @todo
  }
}

.close {
  font-weight: 500;
  line-height: 1;
  font-size: 12px;
  width: 20px;
  height: 20px;
  border-radius: 20px;
  background-color: var(--gds-color-ui-02);
  color: var(--gds-color-white);
  display: inline-flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  top: 0;
  right: 0;
  transform: translate(20%, -50%);
}
</style>

<script>
export default {
  props: {
    isError: {type: Boolean, default: false},
    autoClose: {type: [Boolean, Number], default: false},
  },
  emits: ['close'],
  computed: {
    autoCloseTimeout() {
      return typeof this.autoClose === 'number' ? this.autoClose : 5000;
    }
  },
  mounted() {
    if (this.autoClose) {
      setTimeout(() => this.close(), this.autoCloseTimeout);
    }
  },
  methods: {
    close() {
      this.$emit('close');
    }
  }
}
</script>
