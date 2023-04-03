@extends('layouts.app')

@section('content')

  <div class="archive archive__page archive__page__with_header alignwide">

    @php
      $archive_image = get_field('archive_page_header_image');
      if ($_REQUEST['orderby']){
        $query = new WP_Query(array('orderby'=>'title', 'order'=> $_REQUEST['orderby']));
      }
    @endphp

    <div class="archive__header @if (!$archive_image) archive__header-no-image  @endif">
      @include('partials.breadcrumb')

      <a id="main-content" tabindex="-1"></a>

      @if ($page)
        @if (strpos(get_the_content(), '</h1>') === false)
          <h1 class="page-title">@php(the_title())</h1>
        @endif

        @php(the_content())
      @else
        @include('partials.page-header')
      @endif

      @if ($archive_image)
        <div class="header-image">
          <div class="header-image-icon">
            <img src="{{$archive_image}}" title="archive image">
          </div>
        </div>
      @endif
    </div>

    <div class="archive__main">

      @if ($subcategories)
        <h2>{{ __('Aiheet', 'gds')}}</h2>
        @include('partials.term-buttons', ['terms' => $subcategories])
      @endif

      <div class="archive__filters">
        <div class="archive-filter archive-filter--result-count">
          @if ($total = $query->post_count)
            <p>{{ sprintf(__('%d artikkelia'), $total) }}</p>
          @endif
        </div>
        
      </div>

      @if (!$has_archive_block)
        @include('blocks.article-list', [
          'block' => (object) [
            'classes' => 'wp-block-article-list',
          ],
          'use_pagination' => true,
          'query' => $query,
        ])
      @endif
    </div>
    <div class="archive__sidebar">
      @include('partials.sidebar')
    </div>
  </div>
@endsection
