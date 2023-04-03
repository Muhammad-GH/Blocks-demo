async function setupApp(element, options = {}) {
  const [
    {createApp, defineAsyncComponent},
    {default: store},
  ] = await Promise.all([
    import(/* webpackChunkName: "components/vue" */ 'vue'),
    import(/* webpackChunkName: "components/vue" */ './store'),
  ]);

  const ShareButton = defineAsyncComponent(() => import(/* webpackChunkName: "components/vue" */ './ShareButton.vue'));
  const WooAddToCartTable = defineAsyncComponent(() => import(/* webpackChunkName: "components/vue" */ './WooAddToCartTable.vue'));
  const WooCartForm = defineAsyncComponent(() => import(/* webpackChunkName: "components/vue" */ './WooCartForm.vue'));
  const WooCartContent = defineAsyncComponent(() => import(/* webpackChunkName: "components/vue" */ './WooCartContent.vue'));
  const WooCheckoutProgress = defineAsyncComponent(() => import(/* webpackChunkName: "components/vue" */ './WooCheckoutProgress.vue'));

  return new Promise((resolve, reject) => {
    const app = createApp({
      data() {
        return {
          isLoading: true,
          isEditor: false,
          ...options,
        };
      },
      mounted() {
        this.$nextTick(() => {
          this.isLoading = false
          resolve(app);
        });
      },
      errorCaptured(err) {
        reject(err);
      },
    });

    app.mixin({
      methods: {
        $i18n(key) {
          // Check all parent components for keys in any i18n attributes
          let component = this;
          do {
            if (component.$attrs?.i18n?.[key]) {
              return component.$attrs.i18n[key];
            }
            component = component.$parent;
          } while (component);

          return key;
        },
      },
    })
    app.component('woo-add-to-cart-table', WooAddToCartTable);
    app.component('woo-cart-form', WooCartForm);
    app.component('woo-cart-content', WooCartContent);
    app.component('woo-checkout-progress', WooCheckoutProgress);
    app.component('share-button', ShareButton);
    app.use(store);
    app.mount(element);
  });
}

export default async function init(elements, options = {}) {
  if (!elements.length) {
    return;
  }

  const promises = [];
  for (const el of elements) {
    if (el instanceof HTMLElement && !el.dataset.vApp) {
      promises.push(setupApp(el, options));
    }
  }
  return Promise.all(promises);
}
