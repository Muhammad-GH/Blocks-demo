@if ($label)
  <gds-label size="xl">{!! esc_html($label) !!}</gds-label>
@endif
<div class="post-meta">
  <p>
    @if ($date)
      <span class="post-meta__label">{{ __('Julkaistu: ') }}</span>{{$date}} •
    @endif
    <span class="post-meta__label">{{ __('Lukuaika: ') }}</span>{{$reading_time}}
  </p>
  <p class="post-meta__category">
    •
    @if ($categories)
      @foreach ($categories as $category)
        <a href="{{ get_category_link($category) }}" class="post-meta__category-link">{!! esc_html($category->name) !!}</a>{{ !$loop->last ? ', ' : '' }}
      @endforeach
    @endif
  </p>
</div>
