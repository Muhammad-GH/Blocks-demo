export async function getSwiper() {
  const { default: SwiperCore, Navigation, Pagination, A11y, Thumbs, Swiper } = await import(
    /* webpackChunkName: "components/swiper" */
    /* webpackExports: ["default", "Navigation", "Pagination", "A11y", "Thumbs", "Swiper"] */
    'swiper'
  )

  import(/* webpackChunkName: "components/swiper" */ 'swiper/swiper.scss');

  SwiperCore.use([Navigation, Pagination, A11y, Thumbs])

  return Swiper;
}

export default async function init(container) {
  const Swiper = await getSwiper();

  const settings = JSON.parse(container.dataset.swiper || '{}')
  return new Swiper(container, settings);
}
