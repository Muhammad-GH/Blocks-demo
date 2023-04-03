<div class="sidebar is-container">
  @if ($related_products && $related_products->post_count)
    <h3>{{ __('Saatat olla kiinnostunut näistä', 'gds') }}</h3>

    @include("blocks.article-list", [
      'block' => (object) [
        'classes' => "wp-block-article-list",
      ],
      'use_pagination' => false,
      'query' => $related_products,
    ])
  @endif

  @if ($featured_articles && $featured_articles->post_count)
    <h3>{{ __('Suositellut artikkelit', 'gds') }}</h3>

    @include("blocks.article-list", [
      'block' => (object) [
        'classes' => "wp-block-article-list",
      ],
      'use_pagination' => false,
      'query' => $featured_articles,
    ])
  @endif

  @php(dynamic_sidebar('sidebar-primary'))
</div>
