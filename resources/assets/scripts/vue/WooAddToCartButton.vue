<template>
  <div>
    <notification
      v-if="notice"
      :is-error="notice.level === 'error'"
      :auto-close="notice.level !== 'error'"
      @close="notice = null"
    >
      <div v-html="notice.content" />
    </notification>
    <button
      @click="onClick"
      :disabled="disabled || isAdded"
      :class="[
        $style.button,
        'wp-block-button',
        'wp-block-button__link',
        this.isAdding ? $style.is_adding : '',
        this.isAdded ? 'has-success-background-color' : 'has-ui-01-background-color',
      ]"
    >
      {{ label }}
    </button>
  </div>
</template>

<style lang="scss" module>
.button {
  min-width: 162px;

  &.is_adding {
    cursor: progress;
    opacity: 0.75;
  }
}
</style>

<script lang="js">
import Notification from './Notification.vue'
import {refreshCartCounter} from '../components/cart'
import {mapMutations} from 'vuex'

export default {
  components: {
    Notification,
  },
  emits: ['completed'],
  props: {
    id: { type: Number, required: true },
    variationId: { type: Number, required: false },
    quantity: { type: Number, required: true },
    disabled: { type: Boolean, default: false },
  },
  computed: {
    label() {
      if (this.isAdding) {
        return 'Lisätään...';
      }
      if (this.isAdded) {
        return 'Lisätty';
      }
      return 'Lisää ostoskoriin';
    },
    formData() {
      const formData = new FormData();
      if (this.variationId) {
        formData.append('variation_id', this.variationId);
      }
      formData.append('add-to-cart', this.id);
      formData.append('quantity', this.quantity);

      return formData;
    }
  },
  data() {
    return {
      notice: null,
      isAdding: false,
      isAdded: false,
    };
  },
  methods: {
    ...mapMutations([
      'lock',
      'unlock',
    ]),
    setNotice(html, options = {}) {
      this.notice = {
        content: html,
        ...options
      }
    },
    async onClick() {
      this.lock();
      this.isAdding = true;

      const response = await fetch(window.location.href, {
        method: 'POST',
        body: this.formData,
      });
      const result = await response.text();
      switch (response.status) {
        case 200:
          const parser = new DOMParser();
          const dom = parser.parseFromString(result, 'text/html');
          const notice = dom.querySelector('.woocommerce-notices-wrapper')
          if (!notice) {
            console.error(result);
            this.setNotice('Jokin meni pieleen, ole hyvä ja yritä uudelleen.', {level: 'error'});
            break;
          }
          this.setNotice(notice.outerHTML);
          this.doAdded();
          break;
        default:
            console.error(`${response.status} ${response.statusText}`);
            console.error(result);
            this.setNotice('Jokin meni pieleen, ole hyvä ja yritä uudelleen.', {level: 'error'});
          break;
      }

      refreshCartCounter();
      this.isAdding = false;
      this.unlock();
    },
    doAdded() {
      this.isAdded = true;

      this.$emit('completed');
      setTimeout(() => {
        this.isAdded = false;
      }, 5000);
    }
  },
};
</script>
