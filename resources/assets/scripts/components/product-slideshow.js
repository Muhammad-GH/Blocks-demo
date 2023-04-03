import { getSwiper } from './swiper';

export default async function init(container) {
  if (!container) {
    return;
  }

  const mainContainer = container.querySelector('[data-main-slideshow]');
  const pagerContainer = container.querySelector('[data-pager-slideshow]');

  if (!pagerContainer || !mainContainer) {
    return;
  }

  const Swiper = await getSwiper();


  const pagerSlideshow = new Swiper(pagerContainer.querySelector('.swiper-container'), {
    cssMode: true,
    spaceBetween: 12,
    slidesPerView: 4,
    freeMode: true,
    slideToClickedSlide: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
  });

  const mainSlideshow = new Swiper(mainContainer.querySelector('.swiper-container'), {
    spaceBetween: 12,
    autoHeight: true,
    slideToClickedSlide: true,
    navigation: {
      nextEl: pagerContainer.querySelector('.swiper-button-next'),
      prevEl: pagerContainer.querySelector('.swiper-button-prev'),
    },
    thumbs: {
      swiper: pagerSlideshow,
    },
  });

  return [
    mainSlideshow,
    pagerSlideshow,
  ];
}
