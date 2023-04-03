<div class="teaser is-full teaser--{{ get_post_type() ?? 'custom' }} {{ $image ? 'has-image' : ''}} {{ $is_past ? 'is-past' : '' }}" id="post-{{ get_the_ID() }}">
  @if ($image)
    <div class="teaser__image">
      {!! wp_get_attachment_image($image, 'medium', false, [
          'sizes' => $image_sizes ?? '(min-width: 782px) 60vw, (min-width: 1240px) 792px, 60vw, 100vw',
      ]) !!}
    </div>
  @endif

  <div class="teaser__content">
    <h3 class="teaser__title">
      {!! esc_html($title) !!}
    </h3>

    {!! $description !!}

    <ul class="teaser__meta">
      @if ($date_range)
        <li><strong>{{ __('Aika', 'gds') }}:</strong> {{ $date_range }}</li>
      @endif
      @if ($location)
        <li><strong>{{ __('Paikka', 'gds') }}:</strong> {{ $location }}</li>
      @endif
    </ul>

    <div class="teaser__actions">
      @if ($is_past)
        <span class="teaser__expired-label">
          {{__('Vanhentunut', 'gds')}}
        </span>
      @else
        <div class="wp-block-buttons">
          @if ($program)
            <div class="wp-block-button is-style-outline">
              <a class="wp-block-button__link" href="{{ $program }}" target="_blank">{{ __('Lataa ohjelma', 'gds') }}</a>
            </div>
          @endif
          @if ($registration)
            <div class="wp-block-button">
              <a class="wp-block-button__link" href="{{ $registration }}" target="_blank">{{ __('Ilmoittaudu', 'gds') }}</a>
            </div>
          @endif
        </div>
      @endif
      <div class="teaser__price">
        {!! $price !!}
        @if ($price)
        <span class="tax">
          {{ __('alv. 24 %', 'gds') }}
        </span>
        @endif
      </div>
    </div>
  </div>
</div>
