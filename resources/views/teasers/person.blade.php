<div class="teaser teaser--{{ get_post_type() ?? 'custom' }}">
  <div class="teaser__image">
    @if ($image)
      {!! wp_get_attachment_image($image, 'thumbnail', false, [
          'sizes' => $image_sizes ?? '(max-width: 1100px) 270px, 248px',
      ]) !!}
    @else
      <img src="{{ Roots\asset('images/default-teaser.png') }}" loading="lazy">
    @endif
  </div>

  <div class="teaser__content">
    <p class="teaser__headline">
      {{ $job_title }}
      @if ($job_title && $area) <br /> @endif
        {{ $area }}
    </p>

    <h5 class="teaser__title">
      {!! esc_html($title) !!}
    </h5>
    @if ($phone)
      <a href="tel:{{ $phone_sanitized }}">
        {{ sprintf(__('puhelin %s', 'gds'), $phone) }}
      </a>
    @endif
  </div>
</div>
