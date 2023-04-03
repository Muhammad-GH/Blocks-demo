<div class="{{ esc_attr($block->classes) }} wp-block-media-text has-media-on-the-right is-stacked-on-mobile is-image-fill has-ui-05-background-color has-background" @if (!empty($block->id)) id="{{ $block->id }}" @endif>
  @php
    $original_post = $GLOBALS['post'];
    setup_postdata($featured_post);
    $GLOBALS['post'] = $featured_post;
  @endphp

  <figure class="wp-block-media-text__media">
    {!! get_the_post_thumbnail($featured_post, 'post-thumbnail', []) !!}
  </figure>

  <div class="wp-block-media-text__content">
    @include('partials.entry-meta-single')
    <h2 class="has-l-heading-font-size">
      <a href="{{ get_permalink() }}">
        {!! esc_html(get_the_title()) !!}
      </a>
    </h2>
    @include('partials.teaser-author', ['class' => 'is-style-large'])

  </div>

  @php
    $GLOBALS['post'] = $original_post;
    wp_reset_postdata();
  @endphp
</div>


