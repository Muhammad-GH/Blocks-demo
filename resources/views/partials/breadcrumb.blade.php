@if (!is_front_page() && function_exists('woocommerce_breadcrumb'))
  <div class="breadcrumb alignwide">
    @php(woocommerce_breadcrumb([
      'delimiter' => '<span class="breadcrumb__delimiter" aria-hidden="true">&gt;</span>'
    ]))
  </div>
@endif
