@php($level = $level ?? 0)
<ul class="term-tree is-level-{{ $level }}">
  @foreach ($tree as $term)
    <li class="term-tree__item {{ $term->children ? 'has-children' : '' }}">
      <a
        class="term-tree__link {{ ($term->children || is_tax($term->taxonomy, $term->term_id)) ? 'is-active' : '' }}"
        href="{{ get_term_link($term) }}"
      >
        {{ $term->name }}
      </a>
      @if ($term->children)
        @include('partials.term-tree', [
          'tree' => $term->children,
          'level' => $level + 1
        ])
      @endif
    </li>
  @endforeach
</ul>
