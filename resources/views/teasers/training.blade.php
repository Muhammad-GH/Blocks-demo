<div class="teaser is-wide teaser--{{ get_post_type() ?? 'custom' }} {{ $image ? 'has-image' : ''}} {{ $is_past ? 'is-past' : '' }}">
  @if ($image)
    <div class="teaser__image">
      {!! wp_get_attachment_image($image, 'full', false, [
          'sizes' => $image_sizes ?? '(min-width: 782px) 486px, 80px',
      ]) !!}
    </div>
  @endif

  <div class="teaser__content">
    <p class="teaser__headline">
      {!! $date !!}
      @if ($short_location) • {{ $short_location }} @endif
    </p>

    <h3 class="teaser__title">
      <a class="teaser__link" href="{{ $permalink }}">
        {!! esc_html($title) !!}
      </a>
    </h3>

    <div class="teaser__actions">
      @if ($is_past)
        <span class="teaser__expired-label">
          {{__('Vanhentunut', 'gds')}}
        </span>
      @else
        <div class="wp-block-buttons">
          @if ($program)
            <div class="wp-block-button is-style-outline">
              <a class="wp-block-button__link has-s-size" href="{{ $permalink }}">{{ __('Lue lisää', 'gds') }}</a>
            </div>
          @endif
          @if ($registration)
            <div class="wp-block-button">
              <a class="wp-block-button__link has-s-size" href="{{ $registration }}" target="_blank">{{ __('Ilmoittaudu', 'gds') }}</a>
            </div>
          @endif
        </div>
      @endif
      <div class="teaser__price">
        {!! $price !!}
      </div>
    </div>
  </div>
</div>
