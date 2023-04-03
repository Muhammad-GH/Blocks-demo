<div class="teaser is-featured teaser--{{ get_post_type() ?? 'custom' }} has-image">
  <div class="teaser__image">
    @if ($image)
      {!! wp_get_attachment_image($image, 'medium', false, [
          'sizes' => $image_sizes ?? '(min-width: 782px) 486px, 80px',
      ]) !!}
    @else
      <img src="{{ Roots\asset('images/default-teaser.png') }}" loading="lazy">
    @endif
  </div>

  <div class="teaser__content">
    <p class="teaser__headline">
      {!! get_the_date() !!}
      @if ($category)
        • <a href="{{ get_term_link($category) }}">{!! esc_html($category->name) !!}</a>
      @endif
    </p>

    <h3 class="teaser__title">
      <a class="teaser__link" href="{{ $permalink }}">
        {!! esc_html($title) !!}
      </a>
    </h3>

    @include('partials.teaser-author')
  </div>
</div>
