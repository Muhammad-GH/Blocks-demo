{{--
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */
--}}

@php global $product; @endphp


@if (post_password_required())
  {!! get_the_password_form() !!}
  @return
@endif

@include('partials.breadcrumb')
<a id="main-content" tabindex="-1"></a>

{{--
@hooked wc_print_notices - 10
--}}
@php(do_action('woocommerce_before_single_product'))

<div id="product-{{ the_ID() }}" {{ wc_product_class('alignwide product-page', $product) }}>
  <div class="product-page__main">
    <div class="summary entry-summary entry-content">
      @php(woocommerce_template_single_title())

      {{--
      @hooked woocommerce_template_single_title - 5
      @hooked woocommerce_template_single_rating - 10
      @hooked woocommerce_template_single_price - 10
      @hooked woocommerce_template_single_excerpt - 20
      @hooked woocommerce_template_single_add_to_cart - 30
      @hooked woocommerce_template_single_meta - 40
      @hooked woocommerce_template_single_sharing - 50
      @hooked WC_Structured_Data::generate_product_data() - 60
      --}}
      @php(do_action('woocommerce_single_product_summary'))

      {{--
      @hooked woocommerce_output_product_data_tabs - 10
      @hooked woocommerce_upsell_display - 15
      @hooked woocommerce_output_related_products - 20
      --}}
      @php(do_action('woocommerce_after_single_product_summary'))

      @php(the_content())

      @if ($contact_form)
        @include('blocks.accordion', [
          'block' => (object) ['classes' => 'wp-block-gds-accordion'],
          'text' => __('Kysy lisää tuotteesta', 'gds'),
          'content' => $contact_form,
        ])
      @endif

      <div class="product-table" data-vue-wrapper id="product-table">
        <woo-add-to-cart-table
          :variations='@json($variations)'
          v-cloak
          class="has-spinner"
        >
        </woo-add-to-cart-table>
      </div>

      {!! $footer !!}
    </div>
  </div>
  <div class="product-page__sidebar">
    {{--
    @hooked woocommerce_show_product_sale_flash - 10
    @hooked woocommerce_show_product_images - 20
    --}}
    @php(do_action('woocommerce_before_single_product_summary'))
    @include('partials.product-slideshow', [
      'gallery' => $gallery,
    ])

    <div class="product-page__mobile-header has-text-align-center">
      @php(woocommerce_template_single_title())

      <div class="product-page__scroll-down wp-block-button is-style-outline">
        <a class="wp-block-button__link has-s-size" href="#product-table">{{ __('Katso kaikki koot', 'gds') }}</a>
      </div>
    </div>

    @if ($checklist)
      <ul class="is-style-checklist has-l-paragraph-font-size has-background has-ui-02-background-color">
        @foreach ($checklist as $item)
          <li><strong>{{ $item }}</strong></li>
        @endforeach
      </ul>
    @endif

    @include('partials.share')
  </div>
  <div class="product-page__footer is-container">
    @if ($upsell_products || $related_products)
      <h3 class="has-text-align-center has-ui-02-color">{{ __('Liittyvät tuotteet', 'gds') }}</h3>

      @include('blocks.product-list', [
        'block' => (object) [
          'style' => null,
          'classes' => 'wp-block-product-list alignwide',
        ],
        'use_pagination' => false,
        'query' => $upsell_products ?: $related_products,
      ])
    @endif
    @php(do_action('woocommerce_after_single_product'))
  </div>
</div>
