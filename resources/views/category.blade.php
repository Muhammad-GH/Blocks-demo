@extends('layouts.app')

@section('content')
  <div class="archive archive__page alignwide">
    <div class="archive__breadcrumb">
      @include('partials.breadcrumb')
    </div>
    <div class="archive__main">
      <a id="main-content" tabindex="-1"></a>

      @include('partials.page-header')

      {!! apply_filters('the_content', category_description()) !!}

      <div class="archive__filters">
        <div class="archive-filter archive-filter--result-count">
          @if ($total = $GLOBALS['wp_query']->post_count)
            <p>{{ sprintf(__('%d artikkelia'), $total) }}</p>
          @endif
        </div>
        <div class="archive-filter archive-filter--sort">
        </div>
      </div>

      @include('blocks.article-list', [
        'block' => (object) [
          'classes' => 'wp-block-article-list',
        ],
        'use_pagination' => true,
        'query' => $GLOBALS['wp_query'],
      ])
    </div>
    <div class="archive__sidebar">
      @include('partials.sidebar')
    </div>
  </div>
@endsection
