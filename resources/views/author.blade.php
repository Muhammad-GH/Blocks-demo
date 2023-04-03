@extends('layouts.app')

@section('content')
  <div class="archive archive__page alignwide">
    <div class="archive__breadcrumb">
      @include('partials.breadcrumb')
    </div>
    <div class="archive__main">
      <a id="main-content" tabindex="-1"></a>

      <div class="archive__author-header">
        @include('partials.card-author')
      </div>

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
