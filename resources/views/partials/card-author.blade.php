<gds-card class="author-card">
  @if ($author_image)
    <div class="author-card__image">
      {!! wp_get_attachment_image($author_image, 'large', false, [
        'sizes' => '250px',
      ]) !!}
    </div>
  @endif

  <div class="author-card__content">
    <p class="author-card__heading">{{ __('Kirjoittanut', 'gds') }}</p>

    @if ($author_job_title)
      <p class="author-card__label">{{ $author_job_title }}</p>
    @endif
    <h1 class="author-card__name">{{ $author_name }}</h1>

    {!! wpautop($author_description) !!}

    @if ($author_link && !is_author())
      <div class="author-card__button">
        <a href="{{ $author_link }}" class="wp-block-button__link">{{ __('Katso kaikki artikkelit', 'gds') }}</a>
      </div>
    @endif
  </div>
</gds-card>
