@php
  $style = ($block instanceof \App\Blocks\Block) ? $block->getBlockStyle() : ($block->style ?? null);
@endphp

<div class="{{ esc_attr($block->classes) }}" @if (!empty($block->id) || $use_pagination) id="{{ $block->id ?? 'listing' }}" @endif>
  <div class="grid @if ($style === 'mobile-carousel') medium:carousel @endif">
    @while ($query->have_posts()) @php($query->the_post())
      <div class="cell {{ $cell_classes ?? 'medium:3' }}">
        @includeFirst(['teasers.' . get_post_type(), 'teasers.teaser'], ['post' => get_post()])
      </div>
    @endwhile
    @php(wp_reset_postdata())
  </div>

  @if ($use_pagination)
    @include('partials.pagination', ['query' => $query, 'fragment' => $block->id ?? 'listing'])
  @endif
</div>
