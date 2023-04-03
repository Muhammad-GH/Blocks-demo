<template>
  <div :class="$style.container">
    <button
      :class="[$style.button, 'share__button']"
      @click="onClick"
    >
      <span>Jaa tämä</span>
      <i class="fal fa-share-alt fa-lg"></i>
    </button>

    <ul
      v-if="isOpen"
      :class="[$style.popup, 'share__popup']"
    >
      <li>
        <button @click="onCopy">
          <i class="fal fa-link fa-xs"></i>
          <span>Kopioi linkki</span>
          <span v-if="isCopied" :class="$style.noticeCopied">Link copied</span>
        </button>
      </li>
      <li>
        <a :href="emailLink" rel="nofollow" target="_blank">
          <i class="fal fa-envelope fa-xs"></i>
          <span>Lähetä sähköposti</span>
        </a>
      </li>
      <li>
        <a :href="facebookLink" title="Share on Facebook" rel="nofollow" target="_blank">
          <i class="fab fa-facebook fa-xs"></i>
          <span>Jaa Facebookissa</span>
        </a>
      </li>
      <li>
        <a :href="twitterLink" title="Share on Twitter" rel="nofollow" target="_blank">
          <i class="fab fa-twitter fa-xs"></i>
          <span>Jaa Twitterissä</span>
        </a>
      </li>
    </ul>
  </div>
</template>

<style lang="scss" module>
@use '~genero-design-system/src/components/gds-heading' as heading;

.container {
  position: relative;
}

.button {
  font-family: var(--gds-heading-2xs-font-family, var(--gds-heading-font-family));
  font-size: var(--gds-heading-2xs-font-size);
  font-weight: var(--gds-heading-2xs-font-weight);
  line-height: var(--gds-heading-2xs-line-height);
  color: inherit;

  span {
    display: inline-block;
    margin-right: var(--gds-spacing-2xs);
  }

  &:hover span {
    text-decoration: underline;
  }
}

.noticeCopied {
  font-size: 12px;
  font-weight: 400;
  line-height: 14px;
  color: var(--gds-color-ui-02);
  background-color: var(--gds-color-ui-05);
  padding: 6px 14px;
  position: absolute;
  left: 100%;
  white-space: nowrap;
  top: 50%;
  transform: translateY(-50%);
  text-decoration: none !important;
  border-radius: 5px;
}

.popup {
  list-style-type: none;
  padding: 12px 16px;
  border: solid 2px var(--gds-color-ui-02);
  border-radius: 16px;
  display: inline-block;
  position: absolute;
  left: 0;
  top: 20px;
  min-width: 136px;
  box-shadow: 2px 3px 8px #0000001f;
  background-color: var(--gds-color-white);

  &::before,
  &::after {
    display: block;
    content: '';
    position: absolute;
    left: 14px;
    bottom: 100%;
    width: 0;
    height: 0;
    border: solid 8px transparent;
    border-width: 14px 8px;
    border-bottom-color: var(--gds-color-ui-02);
  }

  &::after {
    border-bottom-color: var(--gds-color-white);
    border-width: 10px 6px;
    transform: translateX(2px);
  }

  i,
  svg {
    color: var(--gds-color-black-60);
  }

  li:not(:first-child) {
    margin-top: var(--gds-spacing-2xs) !important; // override default list styles
  }

  button,
  a {
    padding: 0;
    font-family: inherit;
    font-weight: var(--gds-body-font-weight);
    font-size: var(--gds-paragraph-s-font-size);
    line-height: var(--gds-paragraph-s-line-height);
    color: var(--gds-color-black) !important;
    text-decoration: none;
    position: relative;

    span {
      display: inline-block;
      margin-left: var(--gds-spacing-2xs);
    }

    &:hover span {
      text-decoration: underline;
    }
  }
}
</style>

<style lang="scss">
.has-background .share__button:hover span {
  opacity: 0.8;
}
</style>

<script>
import { copyText } from 'vue3-clipboard'

export default {
  props: {
    url: { type: String, required: true },
    title: { type: String, required: true },
  },
  computed: {
    emailLink() {
      return `mailto:?subject=${encodeURIComponent(this.title)}&body=${encodeURIComponent(this.url)}`;
    },
    facebookLink() {
      return `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(this.url)}`;
    },
    twitterLink() {
      const text = `${this.title} ${this.url}`;
      return `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}`;
    },
  },
  data() {
    return {
      isOpen: false,
      isCopied: false,
    }
  },
  mounted() {
    document.addEventListener('click', this.maybeClickOutside.bind(this));
  },
  methods: {
    onClick() {
      if (navigator.share) {
        navigator.share({
          title: this.title,
          url: this.url,
        });
      } else {
        this.isOpen = !this.isOpen;
      }
    },
    onCopy() {
      copyText(this.url, undefined, (error, event) => {
        if (error) {
          console.log(error);
        } else {
          this.isCopied = true;
          setTimeout(() => this.isCopied = false, 5000);
        }
      });
    },
    maybeClickOutside(e) {
      const target = e.target;
      if (!this.$el.contains(target)) {
        // Copy to clipboard dummy element
        if (target.tagName === 'BUTTON' && target.textContent === '') {
          return;
        }
        this.isOpen = false;
      }
    }
  }
}
</script>
