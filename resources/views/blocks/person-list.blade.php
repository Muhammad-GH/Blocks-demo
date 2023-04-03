<div class="{{ esc_attr($block->classes) }}" @if (!empty($block->id) || $use_pagination) id="{{ $block->id ?? 'listing' }}" @endif>
  @if ($use_filters)
    <div class="wp-block-buttons" data-department-filters>
      <div class="wp-block-button">
        <button class="wp-block-button__link" data-filter="false">{{ __('Kaikki', 'gds') }}&nbsp;</button>
      </div>

      @foreach ($grouped as $group => $objects)
        <div class="wp-block-button is-style-outline">
          <button class="wp-block-button__link" data-filter="{{ $group }}">{{ $group }}&nbsp;</button>
        </div>
      @endforeach
    </div>

    @foreach ($grouped as $group => $objects)
      <div class="department" id="{{ $group }}" data-filter-section>
        <h3 class="department__name">{{ $group }}</h3>

        <div class="department__list">
          <div class="grid">
            @foreach ($objects as $object)
              @php
                $original_post = $GLOBALS['post'];
                setup_postdata($featured_post);
                $GLOBALS['post'] = $object->post;
              @endphp

              <div class="cell {{ $cell_classes ?? 'medium:3' }}">
                @includeFirst(['teasers.' . get_post_type(), 'teasers.teaser'], ['post' => get_post()])
              </div>

              @php
                $GLOBALS['post'] = $original_post;
                wp_reset_postdata();
              @endphp
            @endforeach
          </div>
        </div>
      </div>
    @endforeach
  @else
    <div class="grid">
      @while ($query->have_posts()) @php($query->the_post())
        <div class="cell {{ $cell_classes ?? 'medium:3' }}">
          @includeFirst(['teasers.' . get_post_type(), 'teasers.teaser'], ['post' => get_post()])
        </div>
      @endwhile
      @php(wp_reset_postdata())
    </div>
  @endif
</div>
