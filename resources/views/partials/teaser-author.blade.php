<div class="teaser__author teaser-author {{ $class ?? '' }}">
  @if ($author_image)
    <div class="teaser-author__image">
      {!! wp_get_attachment_image($author_image, 'tiny', false, [
        'sizes' => $image_sizes ?? '30px',
      ]) !!}
    </div>
  @endif
  <div class="teaser-author__content">
    <h6 class="teaser-author__name">
      <a href="{{ $author_link }}" class="teaser-author__link">{{ $author_name }}</a>
    </h6>
    @if ($author_job_title)
      <p class="teaser-author__label">{{ $author_job_title }}</p>
    @endif
  </div>
</div>
