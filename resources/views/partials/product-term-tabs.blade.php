<div class="term-tree-tabs">
  <div role="tablist">
    @if ($product_area_tree)
      <div
        role="tab"
        aria-selected="{{ $active_tab === 'product_area' ? 'true' : 'false' }}"
        aria-controls="product-area-tab"
        id="product-area-title"
      >
        <span>{{ __('Hae ratkaisu', 'gds') }}</span>
      </div>
    @endif
    @if ($product_category_tree)
      <div
        role="tab"
        aria-selected="{{ $active_tab !== 'product_area'  ? 'true' : 'false' }}"
        aria-controls="product-category-tab"
        id="product-category-title"
      >
        <span>{{ __('Hae tuote', 'gds') }}</span>
      </div>
    @endif
  </div>

  @if ($product_area_tree)
    <div
      tabindex="0"
      role="tabpanel"
      id="product-area-tab"
      aria-labelledby="product-area-title"
      @if ($active_tab !== 'product_area') hidden="" @endif
    >
      @include('partials.term-tree', ['tree' => $product_area_tree])
  </div>
  @endif
  @if ($product_category_tree)
    <div
      tabindex="0"
      role="tabpanel"
      id="product-category-tab"
      aria-labelledby="product-category-title"
      @if ($active_tab === 'product_area') hidden="" @endif
    >
      @include('partials.term-tree', ['tree' => $product_category_tree])
    </div>
  @endif
</div>
