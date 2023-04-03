<template>
  <div :class="[
    $style.container,
    disabled ? $style.is_disabled : '',
  ]">
    <button :class="$style.decrement" @click.prevent="decrement" :disabled="disabled">-</button>
    <div :class="$style.input_wrapper">
      <span :class="$style.width_machine">{{ modelValue || 0 }}</span>
      <slot>
        <input
          type="number"
          v-bind="$attrs"
          :disabled="disabled"
          :value="modelValue"
          @input="onInput"
        />
      </slot>
    </div>
    <button :class="$style.increment" @click.prevent="increment" :disabled="disabled">+</button>
  </div>
</template>

<style module lang="scss">
@use '~genero-design-system/src/components/gds-heading' as heading;

.container {
  color: var(--gds-color-black);
  background-color: var(--gds-color-white);
  border: solid 2px var(--gds-color-black-15);
  border-radius: 50px;
  display: grid;
  grid-template-columns: auto 1fr auto;
  min-width: 106px;
  height: 38px;
  box-sizing: border-box;
}

.input_wrapper {
  position: relative;
  overflow: hidden;
}

.width_machine {
  @include heading.size-xs;

  -webkit-appearance: none;
  outline: none;
  color: inherit;
  padding: 6px 0;
}

.increment,
.decrement {
  @include heading.size-xs;

  color: inherit;
  margin: 0;
  padding: 0 var(--gds-spacing-s);
  height: 100%;
  align-items: center;
  display: flex;

  .is_disabled & {
    cursor: default;
  }
}
</style>

<style scoped lang="scss">
@use '~genero-design-system/src/components/gds-heading' as heading;

input[type="number"] {
  @include heading.size-xs;

  -webkit-appearance: none;
  outline: none;
  color: inherit;
  padding: 5px 0;
  position: absolute;
  border: 0;
  left: 20px;
  right: 0;
  margin: 0;
  top: 0;
  bottom: 0;
  background-color: var(--gds-color-white);
  text-align: center;
  box-shadow: none;

  &::-webkit-outer-spin-button,
  &::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
}

</style>

<script>
export default {
  props: {
    modelValue: { type: Number, default: 0 },
    disabled: { type: Boolean, default: false },
  },
  emits: ['update:modelValue'],
  mounted() {
    this.$input = this.$el.querySelector('input[type="number"]');
  },
  methods: {
    increment() {
      this.$input.stepUp();
      this.$emit('update:modelValue', this.$input.value);
    },
    decrement() {
      this.$input.stepDown();
      this.$emit('update:modelValue', this.$input.value);
    },
    onInput(event) {
      this.$emit('update:modelValue', event.target.value);
    },
  }
}
</script>
