<div class="teaser is-wide teaser--search-result {{ $image ? 'has-image' : ''}} is-{{ get_post_type() }}">
  @if ($image)
    <div class="teaser__image">
      {!! wp_get_attachment_image($image, 'thumbnail', false, [
          'sizes' => $image_sizes ?? '(max-width: 1100px) 270px, 248px',
      ]) !!}
    </div>
  @endif

  <div class="teaser__content">
    <p class="teaser__headline">
      {{ $label }}
    </p>

    <h4 class="teaser__title">
      <a class="teaser__link" href="{{ $permalink }}">
        {!! $title !!}
      </a>
    </h4>

    @if ($excerpt = get_the_excerpt())
      <div class="teaser__excerpt">
        {!! get_the_excerpt() !!}
      </div>
    @endif
  </div>
</div>
