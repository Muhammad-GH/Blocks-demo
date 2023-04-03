<div {{ wc_product_class('teaser teaser--product', $product) }}>
  <div class="teaser__image">
    @if ($image)
      {!! wp_get_attachment_image($image, 'thumbnail', false, [
          'sizes' => $image_sizes ?? '(max-width: 1100px) 270px, 248px',
      ]) !!}
    @else
      <img src="{{ Roots\asset('images/default-placeholder.png') }}" loading="lazy">
    @endif
  </div>
  <div class="teaser__content">
    @php(do_action('woocommerce_before_shop_loop_item_title'))
    @php(do_action('woocommerce_shop_loop_item_title'))

    <h5 class="teaser__title">
      <a class="teaser__link" href="{{ $permalink }}">
        {!! esc_html($title) !!}
      </a>
    </h5>

    @if ($excerpt ?? false)
      <p class="teaser__excerpt">
        {!! esc_html($excerpt) !!}
      </p>
    @endif

    <div class="teaser__price">
      @if ($can_read_price)
        @php(woocommerce_template_loop_price())
      @endif
    </div>

    @php(do_action('woocommerce_after_shop_loop_item_title'))
    @php(do_action('woocommerce_after_shop_loop_item'))

    @if ($categories)
      <gds-tag-group class="teaser__tags">
        @foreach ($categories as $term)
          <gds-tag href="{{ get_term_link($term) }}">{{ $term->name }}</gds-tag>
        @endforeach
      </gds-tag-group>
    @endif
  </div>
</div>
