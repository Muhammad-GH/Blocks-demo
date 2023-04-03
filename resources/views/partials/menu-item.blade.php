@if ($item->children && !isset($slot))
  <gds-menu-item-nested slot="item">
    <a
      slot="link"
      href="{{ $item->url }}"
      @if ($item->target ?? false) target="{{ $item->target }}" @endif
      @if ($item->title ?? false ) title="{{ $item->title }}" @endif
      class="{{ ($item->active || $item->activeAncestor) ? 'active': '' }} {{ $class ?? '' }}"
      @if ($item->active) aria-current="page" @endif
    >
      <gds-menu-item>{!! esc_html($item->label) !!}</gds-menu-item>
    </a>

    <span slot="submenu-icon">
      <span class="fal fa-angle-right"></span>
    </span>

    <div class="megamenu" slot="submenu">
      <button class="megamenu__back" data-megamenu-close>
        <i class="fal fa-long-arrow-left"></i>
        {{ __('Takaisin', 'gds') }}
      </button>

      <gds-menu-item class="megamenu__title">
        {!! esc_html($item->label) !!}
      </gds-menu-item>

      @foreach ($item->children as $child)
        @include('partials.menu-item', ['item' => $child, 'slot' => 'submenu-item'])
      @endforeach
    </div>
  </gds-menu-item-nested>
@else
  <a
    slot="{{ $slot ?? 'item' }}"
    href="{{ $item->url }}"
    @if ($item->target ?? false) target="{{ $item->target }}" @endif
    @if ($item->title ?? false ) title="{{ $item->title }}" @endif
    class="{{ ($item->active || $item->activeAncestor) ? 'active': '' }} {{ $class ?? '' }}"
    @if ($item->active) aria-current="page" @endif
  >
    <gds-menu-item>{!! esc_html($item->label) !!}</gds-menu-item>
  </a>
@endif
