{{--
The Template for displaying product archives, including the main shop page which is a post type archive

This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see https://docs.woocommerce.com/document/template-structure/
@package WooCommerce/Templates
@version 3.4.0
--}}

@extends('archive')

@section('content')
  <div class="archive archive__page archive--product alignwide {{ $is_root ? 'is-root-term' : '' }}">
    <div class="archive__sidebar">
      @if ($product_category_tree || $product_area_tree)
        @include('partials.product-term-tabs', [
          'product_category_tree' => $product_category_tree,
          'product_area_tree' => $product_area_tree,
          'active_tab' => (is_tax('product_area') || $is_company_term && $is_root) ? 'product_area' : 'product_cat',
        ])
      @endif
    </div>

    <div class="archive__header @if (!$image) archive__header-no-image  @endif">
      @include('partials.breadcrumb')

      <a id="main-content" tabindex="-1"></a>

      <h1 class="woocommerce-products-header__title page-title">{!! $page_title !!}</h1>

      @if ($image)
        <div class="header-image">
          <div class="header-image-icon">
            {!! wp_get_attachment_image($image, 'thumbnail', false, []) !!}
          </div>
        </div>
      @endif

      @if ($parent_term)
        <a href="{{ get_term_link($parent_term) }}" class="archive__level-up-link">
          <i class="fal fa-long-arrow-left fa-2x"></i>
          {{ __('Takaisin', 'gds') }}
        </a>
      @endif
    </div>

    <div class="archive__main">
      <div class="is-container">
        @php
          do_action('get_header', 'shop');
          do_action('woocommerce_before_main_content');
        @endphp

        <div class="archive__description--desktop">
          @php
            do_action('woocommerce_archive_description')
          @endphp

          @if ($footer && !empty(term_description($term->term_id, 'product_area')))
            <span class="read-more"><a href="#footer_content">{{ __('Lue lisää', 'gds') }}</a></span>
          @endif
        </div>
        
        @if ($subcategories)
          @if ($is_root)
            <h2 class="archive__taxonomy-label">{{ $taxonomy_label }}</h2>
          @endif

          @include('partials.term-buttons', ['terms' => $subcategories])
        @endif

        @php   
        $term_id = get_queried_object()->term_id; //Get ID of current term
        $ancestors = get_ancestors( $term_id, 'product_area' ); // Get a list of ancestors

        $p_flag = true;
        if( is_tax('product_area') && $subcategories ) {
          if(count($ancestors) == 2){
            $p_flag = true;
          }else{
            $p_flag = false;
          }
        }else{
          $p_flag = true;
        }
        @endphp

        @if($p_flag)
          <div class="archive__description--mobile">
            @php
              do_action('woocommerce_archive_description')
            @endphp
          </div>

          {{-- Root category only shows subcategories --}}
          @if (!$is_root)
            {{-- If there are recommended products, show them instead of product list --}}
            @if ($recommended_products)
              <h2>{{ __('Suosittelemme', 'gds') }}</h2>

              @include('blocks.product-list', [
                'block' => (object) [
                  'style' => 'mobile-carousel',
                  'classes' => 'wp-block-product-list',
                ],
                'cell_classes' => 'medium:6 large:4',
                'use_pagination' => false,
                'query' => $recommended_products,
              ])
            @else
              @if (woocommerce_product_loop())
                @php
                  do_action('woocommerce_before_shop_loop');
                @endphp

                <div class="archive__filters">
                  <div class="archive-filter archive-filter--result-count">
                    @if ($total = wc_get_loop_prop('total'))
                      <p>{{ sprintf(__('%d tuotetta'), $total) }}</p>
                    @endif
                  </div>
                  {{--
                  @if (!$is_company_term)
                    <div class="archive-filter archive-filter--sort">
                      @php woocommerce_catalog_ordering() @endphp
                    </div>
                  @endif
                  --}}
                </div>

                @if (wc_get_loop_prop('total'))
                  @include('blocks.product-list', [
                    'block' => (object) [
                      'style' => null,
                      'classes' => 'wp-block-product-list',
                    ],
                    'cell_classes' => 'medium:6 large:4',
                    'use_pagination' => true,
                    'query' => $query,
                  ])
                @endif

                @php
                  do_action('woocommerce_after_shop_loop');
                @endphp
              @else
                @php
                  do_action('woocommerce_no_products_found')
                @endphp
              @endif
            @endif

            @if ($recommended_articles)
              <h2>{{ __('Aiheeseen liittyvää', 'gds') }}</h2>

              @include('blocks.article-list', [
                'block' => (object) [
                  'style' => null,
                  'classes' => 'wp-block-article-list',
                ],
                'use_pagination' => false,
                'query' => $recommended_articles,
              ])

              <div class="wp-block-buttons is-content-justification-center">
                <div class="wp-block-button is-style-outline">
                  <a href="{{ get_post_type_archive_link('post') }}" class="wp-block-button__link">{{ __('Lisää artikkeleita', 'gds') }}</a>
                </div>
              </div>
            @endif
          @endif

        @endif

        @if ($footer)
          <div id="footer_content" class="archive__footer">
            {!! $footer !!}
          </div>
        @endif

        @php
          do_action('woocommerce_after_main_content');
          do_action('get_sidebar', 'shop');
          do_action('get_footer', 'shop');
        @endphp
      </div>
    </div>
  </div>
@endsection
