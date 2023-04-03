<template>
  <div>
    <ol :class="$style.steps" ref="list">
      <li
        v-for="(step, name) in steps"
        :key="name"
        :class="[
          $style.step,
          active === name ? $style.is_active : ''
        ]"
      >
        <a v-if="step.url" :href="step.url">
          {{ step.label }}
        </a>
        <span v-else>
          {{ step.label }}
        </span>
      </li>
    </ol>
    <div :class="$style.progress_bar_container">
      <div :class="$style.progress_bar" :style="{width: progressBarWidth}" />
    </div>
  </div>
</template>

<style lang="scss" module>
@use '@/common/breakpoints' as *;
@use '~genero-design-system/src/components/gds-heading' as heading;

.steps {
  display: flex;
  justify-content: space-between;
  padding-left: 0 !important;
  list-style-position: inside;
  margin-bottom: var(--gds-spacing-2xs);

  @include mq($until: mobile) {
    list-style-type: none;
  }
}

.step {
  margin-top: 0 !important;
  margin-left: var(--gds-spacing-xs);
  margin-right: var(--gds-spacing-xs);
  padding-left: 0 !important;
  // Same as breadcrumb
  font-size: 12px;
  font-weight: 500;
  line-height: 1;
  text-align: center;

  @include mq($from: medium) {
    margin-left: var(--gds-spacing-m);
    margin-right: var(--gds-spacing-m);
    font-family: var(--gds-heading-2xs-font-family, var(--gds-heading-font-family));
    font-size: var(--gds-heading-2xs-font-size);
    font-weight: var(--gds-heading-2xs-font-weight);
    line-height: var(--gds-heading-2xs-line-height);
    text-transform: var(--gds-heading-2xs-text-transform);
    letter-spacing: var(--gds-heading-2xs-letter-spacing);
    margin-top: 0;
    margin-bottom: 0;
    color: var(--gds-color-black-60);
  }

  a {
    color: inherit;
    font-weight: inherit;
  }

  &.is_active {
    color: var(--gds-color-black);
    position: relative;

    &::after {
      position: absolute;
      display: block;
      content: '';
      left: calc(-1 * var(--gds-spacing-xs));
      right: calc(-1 * var(--gds-spacing-xs));
      top: calc(100% + var(--gds-spacing-2xs));
      background-color: var(--gds-color-ui-01);
      height: 11px;
      border-radius: 8px;

      @include mq($from: medium) {
        left: calc(-1 * var(--gds-spacing-m));
        right: calc(-1 * var(--gds-spacing-m));
      }
    }
  }
}

.progress_bar_container {
  background-color: var(--gds-color-black-15);
  height: 11px;
  border-radius: 8px;

  .progress_bar {
    background-color: var(--gds-color-ui-01);
    height: 100%;
    border-radius: 8px;
  }
}
</style>

<script lang="js">
export default {
  props: {
    steps: { type: Object, required: true },
    active: { type: String, default: null  },
  },
  computed: {
    progressBarWidth() {
      const currentStepIdx = Object.keys(this.steps).findIndex((step) => step === this.active);
      const stepCount = Object.keys(this.steps).length;

      console.log(this);

      const progress = (currentStepIdx) / (stepCount - 1);

      return `${progress * 100}%`;
    }
  }
};
</script>
