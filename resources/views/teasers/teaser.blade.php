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
      {!! get_the_date() !!}
    </p>

    <h5 class="teaser__title">
      <a class="teaser__link" href="{{ $permalink }}">
        {!! esc_html($title) !!}
      </a>
    </h5>
  </div>
</div>
