<div class="term-buttons wp-block-buttons is-style-grid">
  @foreach ($terms as $term)
    @php($image = get_term_meta($term->term_id, 'thumbnail_id', true))
    <div class="wp-block-button is-style-block {{ $image ? 'has-image' : '' }}">
      <a href="{{ get_term_link($term) }}" class="wp-block-button__link">
        @if ($image)
          <div class="button-image">
            {!! wp_get_attachment_image($image, 'tiny', false, []) !!}
          </div>
        @endif

        {{ $term->name }} <span class="button-count"> ({{ $term->count }})</span>
      </a>
    </div>
  @endforeach
</div>
