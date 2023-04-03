<div class="product-slideshow">
  @if (count($gallery) > 1)
    <div class="product-slideshow__main swiper-container" data-main-slideshow>
      <div class="swiper-container">
        <div class="swiper-wrapper">
          @foreach ($gallery as $image)
            <div class="swiper-slide">
              <a class="lightbox-trigger no-barba" href="{{ wp_get_attachment_url($image) }}">
                {!! wp_get_attachment_image($image, 'medium', false, [
                    'sizes' => $image_sizes ?? '(max-width: 1100px) 282px, 248px',
                ]) !!}
              </a>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <div class="product-slideshow__pager" data-pager-slideshow>
      <div class="swiper-container">
        <div class="swiper-wrapper">
          @foreach ($gallery as $image)
            <div class="swiper-slide">
              {!! wp_get_attachment_image($image, 'tiny', false, [
                  'sizes' => '50px',
              ]) !!}
            </div>
          @endforeach
        </div>
      </div>

      <div class="swiper-button-next">&gt;</div>
      <div class="swiper-button-prev">&lt;</div>
    </div>
  @else
    @foreach ($gallery as $image)
      <a class="lightbox-trigger no-barba" href="{{ wp_get_attachment_url($image) }}">
        {!! wp_get_attachment_image($image, 'medium', false, [
            'sizes' => $image_sizes ?? '(max-width: 1100px) 282px, 248px',
        ]) !!}
      </a>
    @endforeach
  @endif
</div>
