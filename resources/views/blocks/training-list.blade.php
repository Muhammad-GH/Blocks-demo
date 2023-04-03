@php
  $style = ($block instanceof \App\Blocks\Block) ? $block->getBlockStyle() : ($block->style ?? null);
@endphp

<div class="{{ esc_attr($block->classes) }}" @if (!empty($block->id) || $use_pagination) id="{{ $block->id ?? 'listing' }}" @endif>
  @if (!empty($featured_post))
    @php
      $original_post = $GLOBALS['post'];
      setup_postdata($featured_post);
      $GLOBALS['post'] = $featured_post;
    @endphp

    @includeFirst(['teasers.' . get_post_type() . '-featured', 'teasers.teaser'], ['post' => $featured_post])

    @php
      $GLOBALS['post'] = $original_post;
      wp_reset_postdata();
    @endphp
  @endif

  @if ($style === 'full')
    <div class="grid">
      @while ($query->have_posts()) @php $query->the_post() @endphp
        <div class="cell {{ $cell_classes ?? '' }}">
          @includeFirst(['teasers.' . get_post_type() . '-full', 'teasers.teaser'], ['post' => get_post()])
        </div>
      @endwhile
      @php wp_reset_postdata() @endphp
    </div>
  @else
    <div class="grid">
      @while ($query->have_posts()) @php $query->the_post() @endphp
        <div class="cell {{ $cell_classes ?? '' }}">
          @includeFirst(['teasers.' . get_post_type(), 'teasers.teaser'], ['post' => get_post()])
        </div>
      @endwhile
      @php wp_reset_postdata() @endphp
    </div>
  @endif

  @if ($use_pagination)
    @include('partials.pagination', ['query' => $query, 'fragment' => $block->id ?? 'article-listing'])
  @endif
</div>


