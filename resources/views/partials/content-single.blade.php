<article @php(post_class('alignfull single-page'))>
  <div class="single-page__breadcrumb">
    @include('partials.breadcrumb')
    <a id="main-content" tabindex="-1"></a>
  </div>

  @if (strpos(get_the_content(), '</h1>') === false)
    @if (has_post_thumbnail())
      <div class="single-page__hero wp-block-featured-article wp-block-media-text alignfull has-media-on-the-right is-stacked-on-mobile is-image-fill has-ui-01-background-color has-background">
        <figure class="wp-block-media-text__media">
          @php(the_post_thumbnail('post-thumbnail', []))
        </figure>
        <div class="wp-block-media-text__content">
          @include('partials.entry-meta-single')

          <h1>@php(the_title())</h1>

          @include('partials.teaser-author', ['class' => 'is-style-large'])
          @include('partials.share')
        </div>
      </div>
    @else
      <div class="wp-block-group has-background has-light-blue-background-color has-text-align-center alignfull">
        <div class="wp-block-group__inner-container">
          @include('partials.entry-meta')
        </div>
      </div>
    @endif
  @endif

  <div class="single-page__page alignwide">
    <div class="single-page__main entry-content">
      @php(the_content())

      @include('partials.card-author')
    </div>
    <div class="single-page__sidebar">
      @include('partials.sidebar')
    </div>
  </div>
</article>
