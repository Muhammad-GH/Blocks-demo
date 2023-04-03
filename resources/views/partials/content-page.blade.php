@if ($show_sidebar)
  <div @php(post_class('alignfull single-page'))>
    @if ($show_breadcrumb)
      <div class="single-page__breadcrumb">
        @include('partials.breadcrumb')
        <a id="main-content" tabindex="-1"></a>
      </div>
    @endif
    <div class="single-page__page alignwide">
      <div class="single-page__main entry-content">
        @if ($show_heading)
          <h1 class="{{ $show_sidebar ? '' : 'has-text-align-center' }}">@php(the_title())</h1>
        @endif

        @php(the_content())
        {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
      </div>
      <div class="single-page__sidebar">
        @include('partials.sidebar')
      </div>
    </div>
  </div>
@else
  @if ($show_breadcrumb)
    @include('partials.breadcrumb')
    <a id="main-content" tabindex="-1"></a>
  @endif

  @if ($show_heading)
    <h1 class="{{ $show_sidebar ? '' : 'has-text-align-center' }}">@php(the_title())</h1>
  @endif

  @php(the_content())
  {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
@endif
